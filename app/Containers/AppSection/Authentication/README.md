# [Apiato](https://github.com/apiato/apiato) Authentication Container

Read more about it in Apiato [docs](http://apiato.io/docs/core-features/authentication)

In all application containers, to get the current user, you have to use a [Contract](Contracts/AuthenticatedModel.php).

Also in this container, several caching services are defined:
- [Cache Passport Client](Providers/CacheClientServiceProvider.php)
- [Cache Passport Token](Providers/CacheTokenServiceProvider.php)
- [Cache User](Providers/CacheUserProvider.php) and [User Observer](Events/Observers/UserObserver.php) - with this, we cache retrieving the current user at the login

We will also link the [Event](vendor/laravel/passport/src/Events/AccessTokenCreated.php) for update last login date in the [Handler](app/Containers/AppSection/User/Events/Handlers/LogSuccessfulLogin.php).
