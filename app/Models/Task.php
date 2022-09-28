<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        $task = Task::query()
            ->where('order_of_presentation', $record->order_of_presentation--)
            ->first();

        $value = Task::query()->whereIn('order_of_presentation', [$record->order_of_presentation, $task->order_of_presentation])->get();

        $value = [
             [
                 'id' => $record->id,
                 'order_of_presentation' => ['-', 1] // Add
             ] ,
             [
                 'id' => $task->id,
                 'order_of_presentation' => ['+', 1] // Subtract
             ] ,
        ];
        $index = 'id';

        Task::update([$value, $index]);
    //    Task::upsert(
    //             [
    //                 [
    //                     'order_of_presentation' => $value[1]['order_of_presentation'],
    //                     'name' => $value[0]['name'],
    //                     'cost' => $value[0]['cost'],
    //                     'date_limit' => $value[0]['date_limit'],
    //                 ],
    //                 [
    //                     'order_of_presentation' => $value[0]['order_of_presentation'],
    //                     'name' => $value[1]['name'],
    //                     'cost' => $value[1]['cost'],
    //                     'date_limit' => $value[1]['date_limit'],

    //                 ],
    //             ],
    //             ['order_of_presentation'],
    //         );
    }
}
