<div class="relative w-full" x-data="selectPeriods({{request($name)}})">
    <label class="text-xs block text-xs text-gray-600 font-bold">Periodo</label>
    <input @focus="showListPeriods = true"  @click.outside="showListPeriods = false"  @input="findPeriod()" id="find-period" class="w-full text-sm border p-1 border-gray-400 rounded-sm outline-0 mt-1" type="text" x-model="findPeriodText">
    <input name="{{$name}}" id="period-selected-id" type="hidden" :value="periodSelected">
        <template x-if="showListPeriods">
            <div @scroll.passive="($el.scrollHeight - $el.scrollTop <= $el.clientHeight+2) && loadMore()" id="periods-container" class="overflow-y-auto h-20 absolute top-full left-0 w-full border border-gray-400 bg-white rounded-sm z-50 group-focus-within:pointer-events-auto">
                <template x-if="!isLoadingPeriods">
                    <template x-for="period in periods">
                        <div @click="selectPeriod(period)" class="p-1 hover:bg-gray-200 cursor-pointer rounded-md text-sm">
                            <span x-text="period.name"></span>
                        </div>
                    </template>
                </template>
                <template x-if="isLoadingMore">
                    <div class="py-1.5">
                        <x-loading-spin-component styles="h-5 w-5"/>
                    </div>
                </template>
                <template x-if="isLoadingPeriods">
                    <x-loading-spin-component/>
                </template>
            </div>
        </template>
</div>
