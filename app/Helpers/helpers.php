<?php

use App\Models\Config;

/**
 * Retorna o valor de um campo da tabela de configurações (ID 1).
 *
 * @param string $key O nome do campo a ser buscado (ex: 'send_message_all_status').
 * @return mixed O valor do campo ou null se não for encontrado.
 */
function config_get(string $key): mixed
{
    $config = Config::find(1);

    return $config ? $config->{$key} : null;
}
