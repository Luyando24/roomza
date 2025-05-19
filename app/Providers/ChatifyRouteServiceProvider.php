<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class ChatifyRouteServiceProvider extends ServiceProvider
{
    /**
     * Register Chatify routes.
     */
    public function boot(): void
    {
        $this->registerChatifyRoutes();
    }

    /**
     * Register Chatify routes.
     */
    protected function registerChatifyRoutes(): void
    {
        Route::prefix(config('chatify.routes.prefix'))
            ->namespace(config('chatify.routes.namespace'))
            ->middleware(config('chatify.routes.middleware'))
            ->group(function () {
                Route::get('/', 'MessagesController@index')->name('chatify');
                
                Route::post('/idInfo', 'MessagesController@idFetchData');
                Route::post('/sendMessage', 'MessagesController@send')->name('send.message');
                Route::post('/fetchMessages', 'MessagesController@fetch')->name('fetch.messages');
                Route::get('/download/{fileName}', 'MessagesController@download')->name(config('chatify.attachments.download_route_name'));
                Route::post('/chat/auth', 'MessagesController@pusherAuth')->name('pusher.auth');
                Route::post('/makeSeen', 'MessagesController@seen')->name('messages.seen');
                Route::get('/getContacts', 'MessagesController@getContacts')->name('contacts.get');
                Route::post('/updateContacts', 'MessagesController@updateContactItem')->name('contacts.update');
                Route::post('/star', 'MessagesController@favorite')->name('star');
                Route::post('/favorites', 'MessagesController@getFavorites')->name('favorites');
                Route::get('/search', 'MessagesController@search')->name('search');
                Route::post('/shared', 'MessagesController@sharedPhotos')->name('shared');
                Route::post('/deleteConversation', 'MessagesController@deleteConversation')->name('conversation.delete');
                Route::post('/deleteMessage', 'MessagesController@deleteMessage')->name('message.delete');
                Route::post('/updateSettings', 'MessagesController@updateSettings')->name('avatar.update');
                Route::post('/setActiveStatus', 'MessagesController@setActiveStatus')->name('activeStatus.set');
                
                Route::get('/group/{id}', 'MessagesController@index')->name('group');
                Route::get('/{id}', 'MessagesController@index')->name('user');
            });
    }
}