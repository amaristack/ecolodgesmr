<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TermsModal extends Component
{
    public $showModal = false;

    public function mount()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function acceptTerms()
    {
        $this->showModal = false;
        session(['terms_accepted' => true]);
        $this->emit('termsAccepted');
    }

    public function declineTerms()
    {
        $this->showModal = false;
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.terms-modal');
    }
}
