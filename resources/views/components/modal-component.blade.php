<div x-show="{{ $id }}" id="modal-container" class="fixed inset-0 z-50 bg-[rgba(0,0,0,0.5)] flex items-center justify-center">
    <div class="relative p-4 w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow-sm" @click.outside="{{$id}} = false">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">
                    {{$title}}
                </h3>
                <button @click="{{$id}} = false" id="close-btn" type="button" class="cursor-pointer text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <i class="bi bi-x text-3xl"></i>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                {{$body}}
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                {{$confirmButton}}
                <button @click="{{$id}} = false" id="cancel-btn" data-modal-hide="default-modal" type="button" class="cursor-pointer py-2.5 px-5 ms-3 text-sm font-medium bg-brand-alert text-white rounded-lg">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
</div>
