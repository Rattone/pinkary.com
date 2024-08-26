@props([
    'id',
    'isFollower' => false,
    'isFollowing' => false,
])

<div {{ $attributes }}
    x-data="{
        isFollowing: {{ $isFollowing ? 'true' : 'false' }},
        toggleFollow() {
        @auth
            this.isFollowing ? this.$wire.unfollow({{ $id }}) : this.$wire.follow({{ $id }});
            this.isFollowing ? this.$dispatch('user-unfollowed', { id: {{ $id }} }) : this.$dispatch('user-followed', { id: {{ $id }} });
            this.isFollowing = !this.isFollowing;
        @else
            Livewire.navigate('/login');
        @endauth
        }
    }"
    x-on:user-followed.dot.window="if ($event.detail.id == {{ $id }}) isFollowing = true"
    x-on:user-unfollowed.dot.window="if ($event.detail.id == {{ $id }}) isFollowing = false"
>
    <button
        wire:loading.attr="disabled"
        data-navigate-ignore="true"
        type="button"
        x-on:click="toggleFollow()"
        class="rounded-lg p-1 text-slate-300 transition duration-150 ease-in-out hover:text-white"
    >
        <span x-show="isFollowing" title="Unfollow"><x-heroicon-o-user-minus class="w-4 h-4 inline-block -mt-1 mr-1" /></span>
        <span x-show="!isFollowing" title="Follow"><x-heroicon-o-user-plus class="w-4 h-4 inline-block -mt-1 mr-1" /></span>
    </button>
</div>
