<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Asset') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ route('assets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>
                        
                        <div>
                            <label for="project_id" class="block text-sm font-medium text-gray-700">Project <span class="text-red-500">*</span></label>
                            <select name="project_id" id="project_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Project</option>
                                @foreach($projects as $project)
                                    <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="asset_type_id" class="block text-sm font-medium text-gray-700">Asset Type</label>
                            <select name="asset_type_id" id="asset_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Type</option>
                                @foreach($assetTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('asset_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="asset_tag" class="block text-sm font-medium text-gray-700">Asset Tag <span class="text-red-500">*</span></label>
                                <input type="text" name="asset_tag" id="asset_tag" value="{{ old('asset_tag') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="serial_number" class="block text-sm font-medium text-gray-700">Serial Number</label>
                                <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Asset Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="useful_life_years" class="block text-sm font-medium text-gray-700">Useful Life (Years)</label>
                                <input type="number" step="0.1" name="useful_life_years" id="useful_life_years" value="{{ old('useful_life_years') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity <span class="text-red-500">*</span></label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="condition" class="block text-sm font-medium text-gray-700">Condition <span class="text-red-500">*</span></label>
                                <select name="condition" id="condition" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="New" {{ old('condition') == 'New' ? 'selected' : '' }}>New</option>
                                    <option value="Good" {{ old('condition') == 'Good' ? 'selected' : '' }}>Good</option>
                                    <option value="Fair" {{ old('condition') == 'Fair' ? 'selected' : '' }}>Fair</option>
                                    <option value="Poor" {{ old('condition') == 'Poor' ? 'selected' : '' }}>Poor</option>
                                    <option value="Scrap" {{ old('condition') == 'Scrap' ? 'selected' : '' }}>Scrap</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="supplier_name" class="block text-sm font-medium text-gray-700">Supplier Name</label>
                            <input type="text" list="suppliers_list" name="supplier_name" id="supplier_name" value="{{ old('supplier_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Search or type new supplier...">
                            <datalist id="suppliers_list">
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->name }}">
                                @endforeach
                            </datalist>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="delivery_date" class="block text-sm font-medium text-gray-700">Delivery Date</label>
                                <input type="date" name="delivery_date" id="delivery_date" value="{{ old('delivery_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="gr_date" class="block text-sm font-medium text-gray-700">GR Date</label>
                                <input type="date" name="gr_date" id="gr_date" value="{{ old('gr_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="unit_price" class="block text-sm font-medium text-gray-700">Unit Price</label>
                                <input type="number" step="0.01" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                <select name="currency" id="currency" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="AFN" {{ old('currency') == 'AFN' ? 'selected' : '' }}>AFN</option>
                                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EURO" {{ old('currency') == 'EURO' ? 'selected' : '' }}>EURO</option>
                                </select>
                            </div>
                            <div>
                                <label for="total_amount" class="block text-sm font-medium text-gray-700">Total Amount</label>
                                <input type="number" step="0.01" name="total_amount" id="total_amount" value="{{ old('total_amount') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description / Specifications</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <!-- Location & Assignment -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Location & Assignment</h3>
                        
                        <div>
                            <label for="province_id" class="block text-sm font-medium text-gray-700">Province</label>
                            <select name="province_id" id="province_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Province</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department / Location</label>
                            <select name="department_id" id="department_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="room_number" class="block text-sm font-medium text-gray-700">Room Number / Office</label>
                            <input type="text" name="room_number" id="room_number" value="{{ old('room_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="handed_over_by" class="block text-sm font-medium text-gray-700">Handed Over By</label>
                            <input type="text" name="handed_over_by" id="handed_over_by" value="{{ old('handed_over_by') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Name or Title">
                        </div>

                        <div>
                            <label for="handover_date" class="block text-sm font-medium text-gray-700">Handover Date</label>
                            <input type="date" name="handover_date" id="handover_date" value="{{ old('handover_date', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="staff_id" class="block text-sm font-medium text-gray-700">Take over by (Staff Member)</label>
                            <select name="staff_id" id="staff_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">Select Staff</option>
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}" {{ old('staff_id') == $staff->id ? 'selected' : '' }}>{{ $staff->name }} ({{ $staff->department->name ?? 'N/A' }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="documents" class="block text-sm font-medium text-gray-700">Documents (Handover Form, etc.)</label>
                            <input type="file" name="documents[]" id="documents" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('assets.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Create Asset
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>