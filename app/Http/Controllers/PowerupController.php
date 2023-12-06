<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Powerup;
use Illuminate\Http\Request;
use App\Models\UserInventory;
use App\Models\RemainingPowerup;
use App\Models\UserInventoryPowerup;

class PowerupController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $powerups = Powerup::all();

        return view("powerup.index", [
            'powerups' => $powerups,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('powerup.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:powerups'],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
            'type' => ['string'],
            'uses' => ['numeric', 'min:1'],
            'multiplier' => ['numeric', 'min:1.1'],
        ]);

        Powerup::create($data);

        return redirect()->route('powerups.index')->with('success', 'New powerup added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Powerup $powerup) {
        return view('powerup.show', [
            'powerup' => $powerup,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Powerup $powerup) {
        return view('powerup.edit', [
            'powerup' => $powerup,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Powerup $powerup) {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:powerups,name,'.$powerup->id],
            'price' => ['required', 'numeric', 'min:1'],
            'description' => ['string', 'min:3'],
            'type' => ['string'],
            'uses' => ['numeric', 'min:1'],
            'multiplier' => ['numeric', 'min:1.1'],
        ]);

        try {
            $powerup->update($data);
            return redirect()->route('powerups.index')->with('success', 'Powerup updated!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Powerup $powerup) {
        try {
            $powerup->delete();
            return redirect()->route('powerups.index')->with('success', 'Powerup deleted!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }


    public function use (Powerup $powerup) {
        $user = User::where('id', auth()->user()->id)->first();
        $userInventoryIds = UserInventory::where('user_id', auth()->user()->id)->first()->toArray();
        $userInventoryId = $userInventoryIds['id'];

        if(count(RemainingPowerup::where('user_inventory_id', $userInventoryId)->get()) < $user->powerup_limit) {
            UserInventoryController::removePowerupFromInventory($powerup, $userInventoryId);

            $data = [
                'user_inventory_id' => $userInventoryId,
                'remaining_uses' => $powerup->uses,
                'powerup_id' => $powerup->id,
            ];

            RemainingPowerup::create($data);

            return redirect()->back()->with('success', 'Powerup used!');
        } else {
            return redirect()->back()->with('error', 'Cant use another powerup. Limit of '. $user->powerup_limit . ' active powerup rechead!');
        }
    }


    public static function endPowerup(Powerup|int $powerup) {
        if($powerup instanceof Powerup) {
            $remainingPowerup = RemainingPowerup::where('powerup_id', $powerup->id)->first();
            $remainingPowerup->delete();
        } else {
            $remainingPowerup = RemainingPowerup::where('powerup_id', $powerup)->first();
            $remainingPowerup->delete();
        }
    }


    private static function checkActivePowerups(string $type) {
        if(!UserInventory::where('user_id', auth()->user()->id)->first())
            return;

        $userInventoryIds = UserInventory::where('user_id', auth()->user()->id)->first()->toArray();
        $userInventoryId = $userInventoryIds['id'];
        $remainingPowerups = RemainingPowerup::where('user_inventory_id', $userInventoryId)
            ->join('powerups', 'remaining_powerups.powerup_id', '=', 'powerups.id')
            ->where('powerups.type', $type)
            ->get()
            ->toArray();

        if(count($remainingPowerups) > 0) {
            return $remainingPowerups;
        }
    }


    public static function applyPowerupBuffCoins() {
        $coinActivePowerups = self::checkActivePowerups('coins');

        if(isset($coinActivePowerups)) {
            if(count($coinActivePowerups) > 0) {
                foreach($coinActivePowerups as $powerup) {
                    // dd($coinActivePowerups);
                    # Pegar o powerup do remain table
                    $remainingPowerup = RemainingPowerup::where('powerup_id', $powerup['powerup_id'])->get();
                    if(count($remainingPowerup) > 1) {
                        $powerupMultiplier = 0;
                        foreach($remainingPowerup as $remainPowerupUnit) {
                            # Se não tiver uso nenhum então remove ele
                            if($remainPowerupUnit->remaining_uses <= 0) {
                                PowerupController::endPowerup($powerup['powerup_id']);
                                return 1;
                            }
                            # Diminuir seu uso em um
                            $remainPowerupUnit->remaining_uses -= 1;
                            # Pegar o multiplicador do powerup
                            $powerupMultiplier += $powerup['multiplier'];
                            // dd($remainPowerupUnit->remaining_uses);
                            $remainPowerupUnit->save();
                            # Retonar o atributo da task com o multiplicador do powerup
                        }

                        return $powerupMultiplier;
                    } else {
                        # Se não tiver uso nenhum então remove ele
                        $remainingPowerup = $remainingPowerup[0];
                        if($remainingPowerup->remaining_uses <= 0) {
                            PowerupController::endPowerup($powerup['powerup_id']);
                            return 1;
                        }
                        # Diminuir seu uso em um
                        $remainingPowerup->remaining_uses -= 1;
                        # Pegar o multiplicador do powerup
                        $powerupMultiplier = $powerup['multiplier'];
                        // dd($remainingPowerup->remaining_uses);
                        $remainingPowerup->save();
                        # Retonar o atributo da task com o multiplicador do powerup
                        return $powerupMultiplier;
                    }
                }
            }
        }
    }

    public static function applyPowerupBuffExp() {
        $expActivePowerups = self::checkActivePowerups('exp');

        if(isset($expActivePowerups)) {
            if(count($expActivePowerups) > 0) {
                foreach($expActivePowerups as $powerup) {
                    // dd($coinActivePowerups);
                    # Pegar o powerup do remain table
                    $remainingPowerup = RemainingPowerup::where('powerup_id', $powerup['powerup_id'])->get();
                    if(count($remainingPowerup) > 1) {
                        $powerupMultiplier = 0;
                        foreach($remainingPowerup as $remainPowerupUnit) {
                            # Se não tiver uso nenhum então remove ele
                            if($remainPowerupUnit->remaining_uses <= 0) {
                                PowerupController::endPowerup($powerup['powerup_id']);
                                return 1;
                            }
                            # Diminuir seu uso em um
                            $remainPowerupUnit->remaining_uses -= 1;
                            # Pegar o multiplicador do powerup
                            $powerupMultiplier += $powerup['multiplier'];
                            // dd($remainPowerupUnit->remaining_uses);
                            $remainPowerupUnit->save();
                            # Retonar o atributo da task com o multiplicador do powerup
                        }

                        return $powerupMultiplier;
                    } else {
                        $remainingPowerup = $remainingPowerup[0];
                        # Se não tiver uso nenhum então remove ele
                        if($remainingPowerup->remaining_uses <= 0) {
                            PowerupController::endPowerup($powerup['powerup_id']);
                            return 1;
                        }
                        # Pegar o multiplicador do powerup
                        $powerupMultiplier = $powerup['multiplier'];
                        # Diminuir seu uso em um
                        // dd($remainingPowerup->remaining_uses);
                        $remainingPowerup->remaining_uses -= 1;
                        $remainingPowerup->save();
                        # Retonar o atributo da task com o multiplicador do powerup
                        return $powerupMultiplier;
                    }
                }
            }
        }
    }
}
