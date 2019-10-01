<?php

namespace Petecheyne\NovaNotifications\Nova;

use App\Nova\User;
use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Notification extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Petecheyne\NovaNotifications\Models\Notification::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'users.name',
        'users.email',
        'data',
    ];

    public static function group()
    {
        return __('Notifications');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->join('users', 'users.id', '=', 'notifications.notifiable_id')
            ->where('type', 'Petecheyne\NovaNotifications\Notifications\NovaNotification')
            ->select('notifications.*');
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable()->hideFromIndex(),

            MorphTo::make(__('User'), 'notifiable')
                ->types([
                    User::class,
                ])->searchable(),

            Text::make(__('Title'), function () {
                return $this->resource->data['title'];
            }),

            Text::make(__('Message'), function () {
                return $this->resource->data['message'];
            }),

            DateTime::make(__('Read At'), 'read_at'),

            DateTime::make(__('Created At'), 'created_at'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new Metrics\NovaNotifications,
            new Metrics\NovaUnReadNotifications,
            new Metrics\NovaReadNotifications,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }

    public static function authorizedToCreate(Request $request)
    {
        return false;
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }

    public function authorizedToUpdate(Request $request)
    {
        return false;
    }

}
