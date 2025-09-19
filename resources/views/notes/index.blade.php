<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Notes') }}
            </h2>
            <a href="{{ route('notes.create') }}" class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Note
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($notes->isEmpty())
                        <p class="text-gray-500 text-center">You haven't created any notes yet.</p>
                    @else
                        <div class="grid gap-6 mb-6">
                            @foreach($notes as $note)
                                <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-xl font-bold text-blue-800 mb-2">{{ $note->title }}</h3>
                                            <p class="text-gray-600 mb-4">{{ Str::limit($note->content, 150) }}</p>
                                            <span class="text-sm text-gray-500">Created {{ $note->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('notes.edit', $note) }}" class="text-blue-800 hover:text-blue-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-500" onclick="return confirm('Are you sure you want to delete this note?')">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $notes->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>