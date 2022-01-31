<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Cache;
use Carbon\Carbon;
// use Jantinnerezo\LivewireAlert\LivewireAlert;
use File;
class ManageGuide extends Component
{
  	use WithFileUploads;
    // use LivewireAlert;
	public $type_upload, $file, $link;
    public function render()
    {
        return view('livewire.Admin.manage-guide');
    }
    public function store()
    {
        if (Cache::has('guide_link')) {
            Cache::forget('guide_link');
            Cache::forget('guide_time');
        }
    	if ($this->type_upload == 'image') {
            $this->validate([
              'file' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ]);
            $this->file->storeAs('photos','guide.jpg');
            //create cache and move file
            Cache::forever('guide_link', 'image/guide.jpg');
            Cache::forever('guide_time', Carbon::now());
            if (file_exists(storage_path('app/photos/guide.jpg'))) {
                File::move(storage_path('app\photos\guide.jpg'), public_path('image\guide.jpg'));
            }
            $this->file = null;
    	}
        if ($this->type_upload == 'document') {
            $this->validate([
              'file' => 'mimetypes:application/pdf|required|max:10000'
            ]);
            $this->file->storeAs('photos','guide.pdf');
            //create cache and move file
            Cache::forever('guide_link', 'image/guide.pdf');
            Cache::forever('guide_time', Carbon::now());
            if (file_exists(storage_path('app/photos/guide.pdf'))) {
                File::move(storage_path('app\photos\guide.pdf'), public_path('image\guide.pdf'));
            }
            $this->file = null;
        }
        $this->alert('success', 'update guide successfully.', [
            'position' =>  'center', 
            'timer' =>  5000,
            'toast' =>  false, 
            'text' =>  '', 
        ]);
        return redirect()->route('admin.manage.guide');
    }
    public function updateGuide()
    {
        if (Cache::has('guide_link')) {
            Cache::forget('guide_link');
            Cache::forget('guide_time');
            if(file_exists(public_path('image/guide.jpg'))){
                unlink(public_path('image/guide.jpg'));
            }
            if(file_exists(public_path('image/guide.pdf'))){
                unlink(public_path('image/guide.pdf'));
            }
        }
        Cache::forever('guide_link', $this->link);
        Cache::forever('guide_time', Carbon::now());
        $this->link = null;
        $this->alert('success', 'update guide successfully.', [
            'position' =>  'center', 
            'timer' =>  5000,
            'toast' =>  false, 
            'text' =>  '', 
        ]);
    }
 
}

