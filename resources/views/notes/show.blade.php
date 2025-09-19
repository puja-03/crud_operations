<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $note->title }}
            </h2>
            <a href="{{ route('notes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Back to Notes
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <div class="text-sm text-gray-500 mb-4">
                            Created {{ $note->created_at->format('F j, Y, g:i a') }}
                        </div>
                        <div class="prose max-w-none">
                            {!! nl2br(e($note->content)) !!}
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('notes.edit', $note) }}" class="bg-blue-800 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Note
                        </a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 hover:bg-red-500 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this note?')">
                                Delete Note
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>