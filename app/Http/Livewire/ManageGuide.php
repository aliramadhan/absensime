<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Cache;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ManageGuide extends Component
{
  	use WithFileUploads;
    use LivewireAlert;
	public $type_upload, $file, $link;
    public function render()
    {
        return view('livewire.Admin.manage-guide');
    }
    public function store()
    {
    	if ($this->type_upload == 'image') {
		    $this->validate([
		      'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
		    ]);
    	}
    	elseif($this->type_upload == 'doc'){
		    $this->validate([
		      'link' => 'required'
		    ]);
    	}
    	return dd($this->item);
    }
    public function updateGuide()
    {
        if (Cache::has('guide_link')) {
            Cache::forget('guide_link');
        }
        Cache::forever('guide_link', $this->link);
        $this->link = null;
        $this->alert('success', 'update guide successfully.', [
            'position' =>  'center', 
            'timer' =>  5000,
            'toast' =>  false, 
            'text' =>  '', 
        ]);
    }
 
}

