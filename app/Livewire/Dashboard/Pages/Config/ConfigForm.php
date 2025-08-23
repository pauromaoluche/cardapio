<?php

namespace App\Livewire\Dashboard\Pages\Config;

use App\Livewire\Forms\ConfigFormValidation;
use App\Services\ConfigService;
use Livewire\Component;

class ConfigForm extends Component
{
    public $config;

    protected ConfigService $configService;

    public ConfigFormValidation $form;

    public function boot(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function mount()
    {
        $this->config = $this->configService->get();

        $this->form->fill($this->config);
    }

    public function save()
    {
        $this->form->validate();

        $data = $this->form->all();

        try {

            $this->configService->update(1, $data);

            session()->flash('success', 'Configurações atualizadas com sucesso');
            return redirect()->route('dashboard.config');
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro ao salvar a configuração. Se persistir, contate o administrador');

            return redirect()->route('dashboard.config');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.pages.config.config-form')->layout('livewire.dashboard.layouts.app');
    }
}
