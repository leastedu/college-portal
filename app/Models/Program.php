<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Department;
use App\Models\Student;
use App\Models\ProgramCredit;

/**
 * App\Models\Program
 *
 * @property int $id
 * @property string $name
 * @property int $department_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereContains($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Program whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Program extends BaseModel
{
    protected $fillable = [ 'name', 'department_id' ];

    public function department() {
        return $this->belongsTo(Department::class);
    }

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function credits() {
        return $this->hasMany(ProgramCredit::class);
    }

    public static function boot() {
        self::deleting(function ($model) {
            $model->students()->get()->map(function ($student) {
                $student->delete();
            });
            $model->credits()->get()->map(function ($credit) {
                $credit->delete();
            });
        });
    }
}
