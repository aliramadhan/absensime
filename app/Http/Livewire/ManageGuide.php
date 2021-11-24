<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ManageGuide extends Component
{
  	use WithFileUploads;
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
 
}

