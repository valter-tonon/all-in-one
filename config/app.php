<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Nome da Aplicação
    |--------------------------------------------------------------------------
    |
    | Este valor é o nome da sua aplicação. Este valor é usado quando o
    | framework precisa colocar o nome da aplicação em uma notificação ou
    | qualquer outro local conforme exigido pela aplicação ou seus pacotes.
    |
    */

    'name' => env('APP_NAME', 'CRM-ERP SaaS'),

    /*
    |--------------------------------------------------------------------------
    | Ambiente da Aplicação
    |--------------------------------------------------------------------------
    |
    | Este valor determina o "ambiente" em que sua aplicação está atualmente
    | sendo executada. Isso pode determinar como você prefere configurar vários
    | serviços que a aplicação utiliza. Defina isso no seu arquivo ".env".
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Modo de Depuração da Aplicação
    |--------------------------------------------------------------------------
    |
    | Quando sua aplicação está em modo de depuração, mensagens de erro detalhadas com
    | rastreamentos de pilha serão mostradas em cada erro que ocorrer dentro de
    | sua aplicação. Se desativado, uma página de erro genérica simples é mostrada.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL da Aplicação
    |--------------------------------------------------------------------------
    |
    | Esta URL é usada pelo console para gerar URLs corretamente quando usando
    | a ferramenta de linha de comando Artisan. Você deve definir isso para a raiz de
    | sua aplicação para que seja usada ao executar tarefas Artisan.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Fuso Horário da Aplicação
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar o fuso horário padrão para sua aplicação, que
    | será usado pelas funções de data e hora do PHP. Nós definimos isso para um
    | valor sensato para você.
    |
    */

    'timezone' => 'America/Sao_Paulo',

    /*
    |--------------------------------------------------------------------------
    | Configuração de Localidade da Aplicação
    |--------------------------------------------------------------------------
    |
    | A localidade da aplicação determina a localidade padrão que será usada
    | pelo provedor de serviço de tradução. Você é livre para definir este valor
    | para qualquer uma das localidades que serão suportadas pela aplicação.
    |
    */

    'locale' => 'pt_BR',

    /*
    |--------------------------------------------------------------------------
    | Localidade de Fallback da Aplicação
    |--------------------------------------------------------------------------
    |
    | A localidade de fallback determina a localidade a ser usada quando a atual
    | não está disponível. Você pode alterar o valor para corresponder a qualquer uma
    | das pastas de idioma que são fornecidas através da sua aplicação.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Localidade de Faker
    |--------------------------------------------------------------------------
    |
    | Esta localidade será usada pela biblioteca Faker PHP quando gerar dados
    | falsos para seus seeders de banco de dados. Por exemplo, isso será usado para obter
    | números de telefone localizados, informações de endereço e mais.
    |
    */

    'faker_locale' => 'pt_BR',

    /*
    |--------------------------------------------------------------------------
    | Chave de Criptografia
    |--------------------------------------------------------------------------
    |
    | Esta chave é usada pelo serviço de criptografia Illuminate e deve ser definida
    | para uma string aleatória de 32 caracteres, caso contrário, essas strings
    | criptografadas não serão seguras. Faça isso antes de implantar uma aplicação!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Drivers de Manutenção
    |--------------------------------------------------------------------------
    |
    | Esses drivers de manutenção são usados para determinar como as mensagens
    | são armazenadas durante o modo de manutenção. O array "store" fornece
    | o driver de armazenamento e a localização para armazenar as mensagens.
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Provedores de Serviços Autocarregados
    |--------------------------------------------------------------------------
    |
    | Os provedores de serviços listados aqui serão carregados automaticamente no
    | pedido da sua aplicação. Sinta-se à vontade para adicionar seus próprios serviços a
    | esta matriz para conceder funcionalidade expandida à sua aplicação.
    |
    */

    'providers' => [

        /*
         * Provedores de Serviços do Laravel Framework...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Provedores de Serviços da Aplicação...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\VoltServiceProvider::class,
        App\Providers\TenantServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Aliases de Classe
    |--------------------------------------------------------------------------
    |
    | Esta matriz de aliases de classe será registrada quando esta aplicação
    | for iniciada. No entanto, sinta-se à vontade para registrar quantos você desejar,
    | pois os aliases são carregados "preguiçosamente" e não afetarão o desempenho.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Carbon::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Js' => Illuminate\Support\Js::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Tenant' => App\Facades\Tenant::class,

    ],

]; 