@props([
    'id',
    'isFollower' => false,
    'isFollowing' => false,
])

@if(auth()->id() !== $id)
    <div {{ $attributes }}
        x-data="{
            isFollowing: {{ $isFollowing ? 'true' : 'false' }},
            buttonText: '{{ $isFollowing ? 'Unfollow' : ($isFollower ? 'Follow Back' : 'Follow') }}',
            toggleFollow() {
            @auth
                this.isFollowing ? this.$wire.unfollow({{ $id }}) : this.$wire.follow({{ $id }});
                this.isFollowing ? this.$dispatch('user-unfollowed', { id: {{ $id }} }) : this.$dispatch('user-followed', { id: {{ $id }} });
                this.isFollowing = !this.isFollowing;
                this.buttonText = this.isFollowing ? 'Unfollow' : '{{ $isFollower  ? 'Follow Back' : 'Follow' }}';
            @else
                Livewire.navigate('/login');
            @endauth
            }
        }"
        x-on:user-followed.dot.window="if ($event.detail.id == {{ $id }}) isFollowing = true"
        x-on:user-unfollowed.dot.window="if ($event.detail.id == {{ $id }}) isFollowing = false"
    >
        <x-secondary-button
            wire:loading.attr="disabled"
            data-navigate-ignore="true"
            type="button"
            x-on:click="toggleFollow()"
            class="text-xs md:text-sm"
        >
            <span x-text='buttonText' :title='buttonText' ></span>
        </x-secondary-button>
    </div>
@endif
