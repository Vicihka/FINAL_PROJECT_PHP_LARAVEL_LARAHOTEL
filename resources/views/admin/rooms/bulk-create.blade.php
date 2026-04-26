@extends('layouts.admin')

@section('title', 'Bulk Add Rooms')
@section('page-title', 'Bulk Add Rooms')
@section('page-subtitle', 'Generate and create multiple rooms across all floors at once.')

@section('content')
<div class="space-y-6">

    @if($errors->any())
        <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-700">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif


    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-1 text-base font-semibold text-slate-900">Step 1 - Configure</h2>
        <p class="mb-6 text-sm text-slate-500">Choose room type, status, and how many floors and rooms to generate.</p>

        <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-3">
            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Room Type</label>
                <select id="cfg-type" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <option value="">Select room type</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }} - ${{ number_format($type->price_per_night,0) }}/night</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Default Status</label>
                <select id="cfg-status" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="cleaning">Cleaning</option>
                </select>
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Room Number Prefix <span class="font-normal text-slate-400">(optional)</span></label>
                <input type="text" id="cfg-prefix" placeholder="e.g. A to A101, A102..." maxlength="5"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 placeholder:text-slate-400 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Number of Floors</label>
                <input type="number" id="cfg-floors" value="3" min="1" max="50"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
            </div>

            <div>
                <label class="mb-2 block text-sm font-semibold text-slate-700">Rooms per Floor</label>
                <input type="number" id="cfg-per-floor" value="4" min="1" max="50"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-indigo-400 focus:outline-none focus:ring-4 focus:ring-indigo-100">
            </div>

            <div class="flex items-end">
                <button type="button" onclick="generateRooms()"
                    class="w-full rounded-2xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-200 transition hover:bg-indigo-500">
                    Generate Rooms
                </button>
            </div>
        </div>
    </div>


    <div id="preview-section" class="hidden rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Step 2 - Review & Edit</h2>
                <p class="mt-1 text-sm text-slate-500">Edit any room number, delete rooms you don't need, or add extra rooms per floor.</p>
            </div>
            <div class="rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-2 text-sm font-semibold text-indigo-700">
                Total: <span id="total-count">0</span> rooms
            </div>
        </div>

        <div id="floors-container" class="space-y-5"></div>

        <div class="mt-6 border-t border-slate-100 pt-5">
            <button type="button" onclick="addCustomFloor()"
                class="rounded-2xl border border-dashed border-slate-300 px-5 py-3 text-sm font-semibold text-slate-600 transition hover:border-indigo-400 hover:text-indigo-600">
                + Add Another Floor
            </button>
        </div>
    </div>


    <form action="{{ route('admin.rooms.bulk-store') }}" method="POST" id="bulk-form" class="hidden">
        @csrf
        <input type="hidden" name="room_type_id" id="form-type">
        <input type="hidden" name="status" id="form-status">
        <div id="form-rooms-container"></div>

        <div class="flex flex-wrap gap-3">
            <button type="submit"
                class="inline-flex rounded-2xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-200 transition hover:bg-emerald-500">
                Create All <span id="btn-count">0</span> Rooms
            </button>
            <a href="{{ route('admin.rooms.index') }}"
                class="inline-flex rounded-2xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Cancel
            </a>
        </div>
    </form>

</div>

<script>
let floorCounter = 0;

function generateRooms() {
    const floors    = parseInt(document.getElementById('cfg-floors').value) || 1;
    const perFloor  = parseInt(document.getElementById('cfg-per-floor').value) || 1;
    const prefix    = document.getElementById('cfg-prefix').value.trim().toUpperCase();
    const typeVal   = document.getElementById('cfg-type').value;

    if (!typeVal) {
        alert('Please select a room type first.');
        return;
    }

    floorCounter = 0;
    document.getElementById('floors-container').innerHTML = '';
    document.getElementById('preview-section').classList.remove('hidden');
    document.getElementById('bulk-form').classList.remove('hidden');

    for (let f = 1; f <= floors; f++) {
        const rooms = [];
        for (let r = 1; r <= perFloor; r++) {
            rooms.push(prefix + (f * 100 + r));
        }
        addFloorBlock(f, rooms);
    }

    updateCount();
}

function addFloorBlock(floorNum, roomNumbers) {
    floorCounter++;
    const id = 'floor-' + floorCounter;
    const container = document.getElementById('floors-container');

    const div = document.createElement('div');
    div.id = id;
    div.className = 'rounded-2xl border border-slate-200 bg-slate-50/60 p-5';
    div.innerHTML = `
        <div class="mb-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-xs font-bold text-white">${floorNum}</span>
                <span class="text-sm font-semibold text-slate-700">Floor ${floorNum}</span>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="addRoomToFloor('${id}', ${floorNum})"
                    class="rounded-xl bg-white border border-slate-200 px-3 py-1.5 text-xs font-semibold text-slate-600 hover:bg-slate-100">+ Room</button>
                <button type="button" onclick="removeFloor('${id}')"
                    class="rounded-xl bg-rose-50 border border-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-100">Remove Floor</button>
            </div>
        </div>
        <div class="rooms-grid flex flex-wrap gap-2" data-floor="${floorNum}"></div>
    `;
    container.appendChild(div);

    const grid = div.querySelector('.rooms-grid');
    roomNumbers.forEach(num => addRoomChip(grid, floorNum, num));
}

function addRoomChip(grid, floorNum, roomNumber) {
    const chip = document.createElement('div');
    chip.className = 'flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 py-2 shadow-sm';
    chip.innerHTML = `
        <input type="text" value="${roomNumber}" data-floor="${floorNum}"
            class="room-input w-20 border-0 bg-transparent text-sm font-semibold text-slate-800 focus:outline-none focus:ring-0"
            oninput="updateCount()" placeholder="Room #">
        <button type="button" onclick="removeRoom(this)" class="ml-1 text-slate-400 hover:text-rose-500 text-xs font-bold">x</button>
    `;
    grid.appendChild(chip);
    updateCount();
}

function addRoomToFloor(floorId, floorNum) {
    const grid = document.querySelector('#' + floorId + ' .rooms-grid');
    addRoomChip(grid, floorNum, '');
}

function addCustomFloor() {
    const existingFloors = document.querySelectorAll('.rooms-grid');
    const nextFloor = existingFloors.length + 1;
    addFloorBlock(nextFloor, []);
}

function removeFloor(id) {
    document.getElementById(id).remove();
    updateCount();
}

function removeRoom(btn) {
    btn.closest('div.flex.items-center').remove();
    updateCount();
}

function updateCount() {
    const count = document.querySelectorAll('.room-input').length;
    document.getElementById('total-count').textContent = count;
    document.getElementById('btn-count').textContent = count;
    buildFormInputs();
}

function buildFormInputs() {
    document.getElementById('form-type').value   = document.getElementById('cfg-type').value;
    document.getElementById('form-status').value = document.getElementById('cfg-status').value;

    const container = document.getElementById('form-rooms-container');
    container.innerHTML = '';

    document.querySelectorAll('.room-input').forEach((input, i) => {
        const floor = input.dataset.floor;
        container.innerHTML += `<input type="hidden" name="rooms[${i}][room_number]" value="${input.value}">`;
        container.innerHTML += `<input type="hidden" name="rooms[${i}][floor]" value="${floor}">`;
    });
}

document.getElementById('bulk-form').addEventListener('submit', function(e) {
    buildFormInputs();

    const typeVal = document.getElementById('cfg-type').value;
    if (!typeVal) { e.preventDefault(); alert('Please select a room type.'); return; }

    const empties = [...document.querySelectorAll('.room-input')].filter(i => !i.value.trim());
    if (empties.length > 0) {
        e.preventDefault();
        alert('Please fill in all room numbers or remove empty ones.');
        return;
    }
});
</script>
@endsection
