<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver de Sessão Padrão
    |--------------------------------------------------------------------------
    |
    | Esta opção controla o driver de sessão padrão que será usado na
    | requisições. Por padrão, usaremos o driver leve e nativo
    | mas você pode especificar qualquer um dos outros drivers maravilhosos fornecidos aqui.
    |
    | Drivers suportados: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Tempo de Vida da Sessão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode especificar o número de minutos que deseja que a sessão seja
    | permitida para permanecer inativa antes de expirar. Se você quiser que eles
    | expirem imediatamente ao fechar o navegador, defina essa opção como nula.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Criptografia de Sessão
    |--------------------------------------------------------------------------
    |
    | Esta opção permite que você especifique facilmente que todos os seus dados de sessão
    | devem ser criptografados antes de serem armazenados. Todo o criptografia será
    | executada automaticamente pelo Laravel e você pode usar a sessão como de costume.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Localização do Arquivo de Sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar o driver de sessão nativo, precisamos de um local onde os arquivos de sessão
    | podem ser armazenados. Um valor padrão foi definido para você, mas um diferente
    | localização pode ser especificada. Isso só é necessário para sessões de arquivo.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Conexão de Banco de Dados de Sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar os drivers de sessão "database" ou "redis", você pode especificar um
    | conexão que deve ser usada para gerenciar essas sessões. Isso deve
    | corresponder a uma das conexões listadas no seu arquivo de configuração de banco de dados.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Tabela de Banco de Dados de Sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar o driver de sessão "database", você pode especificar a tabela que
    | deve ser usada para armazenar suas sessões. Claro, um valor padrão sensato é
    | fornecido para você; no entanto, você é livre para alterar isso conforme necessário.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Loja de Cache de Sessão
    |--------------------------------------------------------------------------
    |
    | Ao usar um dos drivers de sessão baseados em cache, você pode especificar
    | a loja de cache que deve ser usada para armazenar sessões. Este valor deve
    | corresponder a uma das lojas de cache configuradas em seu arquivo de cache.
    |
    | Depende de: "illuminate/session"
    | Requer: "illuminate/cache"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Loteria de Coleta de Lixo de Sessão
    |--------------------------------------------------------------------------
    |
    | Algumas sessões expirarão eventualmente, então aqui podemos especificar a
    | probabilidade de que a coleta de lixo da sessão seja executada em qualquer solicitação dada.
    | Por padrão, a probabilidade é 2 em 100, ou 2% de chance.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nome do Cookie de Sessão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode alterar o nome do cookie usado para identificar uma sessão
    | instância por ID. O nome especificado aqui será usado toda vez que um
    | cookie é criado pelo framework para cada driver.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Caminho do Cookie de Sessão
    |--------------------------------------------------------------------------
    |
    | O caminho do cookie para o qual o cookie será considerado disponível.
    | Normalmente, isso será a raiz do seu aplicativo, mas você é livre para
    | alterá-lo quando necessário. Por padrão, é definido como '/'.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Domínio do Cookie de Sessão
    |--------------------------------------------------------------------------
    |
    | Aqui você pode alterar o domínio do cookie usado para identificar uma sessão
    | no seu aplicativo. Isso determinará em quais domínios o cookie é
    | disponível em seu aplicativo. Um valor nulo significa que todos os domínios serão aceitos.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Cookies de Sessão HTTPS Apenas
    |--------------------------------------------------------------------------
    |
    | Ao definir esta opção como verdadeira, os cookies de sessão só serão enviados de volta
    | ao servidor se o navegador tiver uma conexão HTTPS. Isso manterá
    | o cookie de sessão mais seguro contra ataques man-in-the-middle.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | Cookies de Sessão HTTP Apenas
    |--------------------------------------------------------------------------
    |
    | Definir este valor como verdadeiro impedirá que o JavaScript acesse o
    | valor do cookie e o cookie só será acessível através do
    | protocolo HTTP. Você é livre para modificar esta opção se necessário.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Cookies de Sessão Apenas para o Mesmo Site
    |--------------------------------------------------------------------------
    |
    | Esta opção determina como seus cookies se comportam quando solicitações entre sites
    | ocorrem, e pode ser usado para mitigar ataques CSRF. Por padrão, nós
    | definiremos este valor como "lax" já que este é um valor padrão seguro.
    |
    | Valores suportados: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

]; 