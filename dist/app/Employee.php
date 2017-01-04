<?php

namespace App;
use Adldap\Laravel\Traits\AdldapUserModelTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable {
	use AdldapUserModelTrait;

			  protected $table = 'dbo.EMPLOYEES';
			  protected $primaryKey = 'Emp_Id';

				/**
				 * The attributes that are mass assignable.
				 *
				 * @var array
				 */
				protected $fillable = [
					'Emp_Name', 'Emp_Username', 'Emp_Password',
				];

				//public adldapUser;

				/**
				 * The attributes that should be hidden for arrays.
				 *
				 * @var array
				 */
				protected $hidden = [
					'password', 'remember_token',
				];

				public function user()
				{
				    return $this->belongsTo(User::class, 'Emp_Id', 'Emp_id');
				}
}
