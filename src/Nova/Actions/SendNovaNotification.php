<?php

namespace Petecheyne\NovaNotifications\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Petecheyne\NovaNotifications\Models\NotificationTemplate;
use Petecheyne\NovaNotifications\Notifications\NovaNotification;

class SendNovaNotification extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public function name()
    {
        return __('Send Notification');
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $notification = NotificationTemplate::find($fields->get('notification'));

        foreach ($models as $model) {
            $model->notify(new NovaNotification($notification->title, $notification->body));
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        return [
            Select::make(__('Notification'))->options(function (){
                return NotificationTemplate::all()->pluck('title', 'id');
            })->displayUsingLabels()
        ];
    }
}
