<div>
    <div class="flex flex-wrap justify-center space-x-4 mb-6 containr mx-auto bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden m-6 p-4">
        <!-- Input สำหรับเลือกวันที่ -->


        <!-- Input สำหรับเลือกประเภทการเดินทาง (join/private) -->
        <div class="flex flex-col items-center">
            <label for="tripType" class="text-sm text-gray-600 mb-1">ประเภทการเดินทาง</label>
            <select wire:model.lazy="tripType" id="tripType" class="form-input px-4 py-2 rounded">
                <option value="">ประเภทการเดินทาง</option>
                <!-- <option value="join">Join</option> -->
                <option value="private">Private</option>
            </select>
        </div>


        <!-- Input สำหรับเลือก package type -->
        <!-- Input สำหรับเลือก package type -->
        <div class="flex flex-col items-center">
            <label for="packageTypes" class="text-sm text-gray-600 mb-1">ประเภทแพ็กเกจ</label>
            <select wire:model.lazy="packageTypes" id="packageTypes" class="form-input px-4 py-2 rounded">
                <option value="">เลือกประเภทแพ็กเกจ</option>
                @foreach ($selectedPackageType as $type)
                    <option value="{{ $type->name_en }}">{{ $type->name_en }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col items-center">
            <label for="date" class="text-sm text-gray-600 mb-1">วันที่เดินทาง</label>
            <input type="date" wire:model.lazy="date" id="date" class="form-input px-4 py-2 rounded" />
        </div>

        <!-- ตรวจสอบว่า package type เป็น 'over_night' หรือไม่ -->
        @if ($packageTypes === 'over_night')
           <div class="flex flex-col items-center">
            <label for="additionalDate" class="text-sm text-gray-600 mb-1">ถึงวันที่</label>
            <input type="date" wire:model.lazy="returndate" id="returndate" class="form-input px-4 py-2 rounded" />
        </div>
        @endif
    </div>
    @if ($packages && $packages->isNotEmpty())
   
        <!-- แสดงรายการแพ็กเกจ -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($packages as $yacht)
                <x-yacht-card :packageid="$yacht->id" :image="$yacht->image" :nameboat="$yacht->name_boat" :date="$date" :datereturn="$returndate" :description="$yacht->yachts->description"
                    :max="$yacht->max" :price="$yacht->prices[0]->regular" />
            @endforeach
        </div>
    @else
        <!-- แสดงข้อความเมื่อไม่พบรายการ -->
        <div class="text-center text-gray-500 mt-6">
           No package found
        </div>
    @endif
</div>
