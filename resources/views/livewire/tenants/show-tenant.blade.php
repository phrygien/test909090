<?php

use App\Models\User;
use Livewire\WithPagination;
use Livewire\Volt\Component;
use TallStackUi\Traits\Interactions; 
use Illuminate\Database\Eloquent\Builder;

new class extends Component {
    use WithPagination;
    use Interactions; 
 
    public ?int $quantity = 5;
 
    public ?string $search = null;

    public ?string $userIdToDelete = null; 

    public function delete(string $id): void
    {
    // Store the user id to delete
    $this->userIdToDelete = $id;
        // 1. The methods `confirm()` and `cancel()` are optional.
    $this->dialog()
        ->question('Warning!', 'Are you sure?')
        ->confirm('Confirm', 'confirmed','Confirmed Successfully')
        ->cancel('Cancel', 'cancelled', 'Cancelled Successfully')
        ->send();
        
    }
 
    public function confirmed(string $message): void
    {
        // Retrieve the stored user id to delete
        $id = $this->userIdToDelete;
        // Delete the user
        //User::findOrFail($id)->delete();

        $this->banner()
            ->close()
            ->success('User deleted successfuly !.')
            ->leave(5)
            ->send();

        //$this->dialog()->success('Success', $message)->send();
    }

    public function cancelled(string $message): void
    {
            $this->banner()
            ->close()
            ->error('This is a banner dispatched through Livewire. Will disappear in 5 seconds.')
            ->leave(5)
            ->send();
        //$this->dialog()->error('Cancelled', $message)->send();
    }

    public function with(): array
    {
        return [
            'headers' => [
                ['index' => 'id', 'label' => '#'],
                ['index' => 'name', 'label' => 'Nom et prenom'],
                ['index' => 'email', 'label' => 'Adresse email'],
                ['index' => 'action'], 
            ],
            'rows' => User::query()
                ->when($this->search, function (Builder $query) {
                    return $query->where('name', 'like', "%{$this->search}%");
                })
                ->paginate($this->quantity)
                ->withQueryString(),
            'type' => 'data', 
        ];
    }

    public function placeholder()
    {
        return <<<'HTML'
                <div role="status">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
        HTML;
    }
}; ?>

<div>
    <x-mc-table :$headers :$rows filter paginate id="users">
        <!-- The $row represents the instance of \App\Model\User of each row -->
        @interact('column_action', $row) 
            <x-mc-button color="red"
                             icon="trash"
                             wire:click="delete('{{ $row->id }}')" />
                             <x-mc-button color="amber"
                             icon="trash"
                             wire:click="delete('{{ $row->id }}')" />
        @endinteract
    </x-mc-table>
 
    <!-- 2: You can pass extra variables to the directive -->
    {{-- <x-mc-table :$headers :$rows filter paginate id="users">
        @interact('column_action', $row, $type) 
            <x-mc-button.circle color="red"
                             icon="trash"
                             wire:click="delete('{{ $row->id }}', '{{ $type }}')" />
        @endinteract
    </x-mc-table> --}}
</div>
