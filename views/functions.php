<?php

use Liman\Toolkit\Shell\Command;

function index()
{
    return view('index');
}

function fetchHostname()
{
    return respond(Command::run('hostname'), 200);
}

function setHostname()
{
    validate([
        'hostname' => 'required|string'
    ]);

    $status = (bool) Command::runSudo('hostnamectl set-hostname @{:hostname} 2>/dev/null 1>/dev/null && echo 1 || echo 0', [
        'hostname' => request('hostname')
    ]);

    if ($status) {
        return respond(__('Hostname değiştirildi.'), 200);
    } else {
        return respond(__('Hostname değiştirilirken bir hata oluştu!'), 201);
    }
}