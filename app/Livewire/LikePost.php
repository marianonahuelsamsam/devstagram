<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{   
    public $post;
    public $isLiked;
    public $contadorLikes;

    public function mount($post) 
    {
        $this->isLiked = $this->post->checklike(auth()->user());
        $this->contadorLikes = $this->post->likes->count();
    }

    public function like() 
    {
        if( $this->post->checkLike( auth()->user() ) ) { // Si retorna true es porque ya se dió me gusta
            auth()->user()->likes()->where('post_id', $this->post->id)->delete(); // Eliminamos el like

            $this->isLiked = false;
            $this->contadorLikes--;
        } else {
            $this->post->likes()->create([
                'user_id' => auth()->user()->id
            ]);

            $this->isLiked = true;
            $this->contadorLikes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
