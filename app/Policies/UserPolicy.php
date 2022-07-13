<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Plan;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
       //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }

    public function checkplan(User $user){
        $plan = $user->checkExpiredPlans;

        if(isset($plan[0]) && ($plan[0] instanceof Plan) && ($plan[0]->allowable_days)){
            $initial_plan       = $plan[0];
            $days_limit         = $initial_plan->allowable_days ;
            $purchased_date     = $initial_plan->pivot->created_at;

             if($purchased_date->addDays($days_limit) <= \Carbon\Carbon::now()){
                $plan[0]->pivot->status=1; $plan[0]->pivot->save();
             }
        }
        if($user->checkExpiredPlans()->exists() && $plan[0]->slug != 'trial-plan')
        {
            return true;
        }
        return false;
    }

    public function checkTrialUsed(User $user){
        $status= auth()->user()->plans()->where('plans.id',1)->exists();
        return $status;        //dd(auth()->user()->plans()->where("id", 1)->exists());
    }
}
