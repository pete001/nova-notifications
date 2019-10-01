Laravel Nova Notifications
============

# Installation

add repository to composer under `repositories` array in your composer file

```json
{
    "type": "path",
    "url": "./packages//petecheyne/nova-notifications"
}
```

Add ` "petecheyne/nova-notifications": "*"` to composer `require` array

And run `composer update` and run `php artisan migrate`

# Add New Notification Templates:

From notification templates resource you can start add new templates

# Send Notifications

From user resource select some users , and run action called `Send Notification` , select template and click send

That's all

# Get user notifications

To get user notifications you should add the following fields to your nova user resource:

```php
use Petecheyne\NovaNotifications\Nova\Actions\SendNovaNotification; 

MorphMany::make(__('Notifications'), 'notifications', Notification::class),
```

You can now add notifications templates , and select some users to send notifications

Enjoy!
