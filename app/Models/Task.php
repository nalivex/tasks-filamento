<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    protected $dates = [
        'date_limit'
      ];

    protected $guarded = ['id'];

    public $timestamps = false;

    public function moveOrderUp($record)
    {
        $value= Task::query()->max('order_of_presentation') + 1;

        $task = Task::query()
            ->where('order_of_presentation', $record->order_of_presentation - 1)
            ->first();

        $id = $record->order_of_presentation;

        $task->update(['order_of_presentation' => $value]);

        $record->update(['order_of_presentation' => $record->order_of_presentation - 1]);

        $task->update(['order_of_presentation' => $id]);

    }

    public function moveOrderDown($record)
    {

        $value= Task::query()->max('order_of_presentation') + 1;

        $task = Task::query()
            ->where('order_of_presentation', $record->order_of_presentation + 1)
            ->first();

        $id = $record->order_of_presentation;

        $task->update(['order_of_presentation' => $value]);

        $record->update(['order_of_presentation' => $record->order_of_presentation + 1]);

        $task->update(['order_of_presentation' => $id]);

    }

}
