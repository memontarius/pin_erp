@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-start">
        <div>
            @if (count($products) > 1)
                <table class="min-w-[629px] mt-1">
                    <thead>
                    <tr class="text-[9px] uppercase text-gray-400 text-left h-6">
                        <th class="pl-5 font-normal w-[25%]">Артикул</th>
                        <th class="pl-5 font-normal w-[25%]">Название</th>
                        <th class="pl-5 font-normal w-[25%]">Статус</th>
                        <th class="pl-5 font-normal w-[25%]">Атрибуты</th>
                    </tr>
                    <tbody class="text-[11px] text-gray-400 font-normal bg-white">
                    @foreach($products as $product)
                        <tr class="h-[55px] border-t border-b border-gray-300">
                            <td class="pl-5">{{ $product->article }}</td>
                            <td class="pl-5">
                                <div
                                    data-product-id="{{ $product->id }}"
                                    class="product-link cursor-pointer">{{ $product->name }}</div>
                            </td>
                            <td class="pl-5">{{ __($product->status->value)  }}</td>
                            <td class="pl-5">
                                @if ($product->data !== null)
                                        <?php $attributes = json_decode($product->data, true); ?>
                                    <ul>
                                        @foreach($attributes as $name => $value)
                                            <li>{{ $name }}: {{$value}}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </thead>
                </table>
            @endif
        </div>
        <div class="mt-4 mr-4">
            <button
                data-modal-target="add-product-modal" data-modal-toggle="add-product-modal"
                type="button"
                class="inline-block font-sans text-white bg-ultra-sky-400 hover:bg-ultra-sky-500 font-medium rounded-lg px-11 py-2 text-[11px]">
                Добавить
            </button>
        </div>
    </div>

    <div data-modal-target="edit-product-modal" class="hidden"></div>
    <div data-modal-target="show-product-modal" class="hidden"></div>

    <!-- Add product modal -->
    <div id="add-product-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative px-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-dark-gray shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 pt-6">
                    <h3 class="text-[20px] font-bold text-white">
                        Добавить продукт
                    </h3>
                    <button type="button"
                            data-modal-hide="add-product-modal"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Закрыть окно</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="px-4 text-white min-h-[380px]">
                    <div class="modal-loader absolute top-1/2 right-1/2" role="status">
                        <svg aria-hidden="true"
                             class="w-8 h-8 relative top-[-8px] left-[8px] text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                             viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor"/>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="modal-content">
                        <form id="add-product-form" class="product-form" action="/">
                            @csrf
                            @method('POST')
                            <div class="errors text-red-600 text-sm">
                            </div>
                            <label class="text-[10px]" for="article">Артикул</label>
                            <input class="block min-w-[75%] h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400"
                                   name="article" id="article" type="text">
                            <label class="text-[10px]" for="name">Название</label>
                            <input class="block min-w-[75%] h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400"
                                   name="name" id="name" type="text" required>
                            <label class="text-[10px]" for="status">Статус</label>

                            <select name="status" id="status"
                                    class="text-sm font-light block min-w-[75%] h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400 py-0">
                                <option value="available">Доступен</option>
                                <option value="unavailable">Недоступен</option>
                            </select>
                            <div class="text-[14px] font-bold block mt-3">Атрибуты</div>

                            <div class="hidden product-attribute w-[75%] mt-4">

                            </div>

                            <button type="button"
                                    class="add-attribute-btn text-xs text-ultra-sky-400 border-dashed border-b border-ultra-sky-400 mt-4">
                                + Добавить атрибут
                            </button>

                            <div class="flex items-center mt-8 pb-8">
                                <button
                                    class="submit-button inline-block font-sans text-white bg-ultra-sky-400 hover:bg-ultra-sky-500 font-medium rounded-lg px-11 py-2 text-[11px]">
                                    <svg aria-hidden="true" role="status"
                                         class="hidden inline w-6 h-4 me-3 text-white animate-spin relative left-1"
                                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="#E5E7EB"/>
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentColor"/>
                                    </svg>
                                    <span class="title">Добавить</span>
                                </button>
                            </div>
                        </form>

                        <div class="attribute-template hidden flex items-center mt-2">
                            <div class="mr-3">
                                <label class="text-sm">
                                    Название
                                    <input
                                        name="attribute-name"
                                        class="block h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400"
                                        type="text" required>
                                </label>
                            </div>
                            <div class="mr-3">
                                <label class="text-sm">
                                    Значение
                                    <input
                                        name="attribute-val"
                                        class="block h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400"
                                        type="text" required>
                                </label>
                            </div>
                            <button class="btn-icon-delete relative top-[14px] right-1 w-6 h-9" type="button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Show product modal -->
    <div id="show-product-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative px-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-dark-gray shadow">
                <div class="modal-loader absolute top-1/2 right-1/2" role="status">
                    <svg aria-hidden="true"
                         class="w-8 h-8 relative top-[-8px] left-[8px] text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"/>
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 pt-6">
                    <div class="title">
                        <h3 class="text-[20px] font-bold text-white">
                            DFETEDFFSG
                        </h3>
                    </div>
                    <div class="flex items-center">
                        <button type="button"
                                class="content-element edit-btn btn-icon-edit mr-1 text-gray-400 bg-gray-800 hover:bg-gray-600 text-sm w-5 h-5 ms-auto inline-flex justify-center items-center ">
                            <span class="sr-only">Edit</span>
                        </button>

                        <form class="form-delete h-[22px]" action="{{ route('product.destroy', 0) }}" method="post">
                            @csrf
                            @method('delete')
                            <button
                                type="submit"
                                value="Delete"
                                class="content-element btn-icon-delete mr-4 text-gray-400 bg-gray-800 hover:bg-gray-600 text-sm w-5 h-5 ms-auto inline-flex justify-center items-center ">
                            </button>
                        </form>

                        <button type="button"
                                data-modal-hide="show-product-modal"
                                class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                </div>

                <!-- Modal body -->
                <div class="px-4 text-white text-sm min-h-[380px] mt-2">
                    <div class="message hidden m-auto"></div>
                    <div class="modal-content">
                        <table>
                            <tr>
                                <td class="opacity-70 pr-10 h-8 align-top">Артикул</td>
                                <td class="align-top product-article"></td>
                            </tr>
                            <tr>
                                <td class="opacity-70 pr-10 h-8 align-top">Название</td>
                                <td class="align-top product-name"></td>
                            </tr>
                            <tr>
                                <td class="opacity-70 pr-10 h-8 align-top">Статус</td>
                                <td class="align-top product-status"></td>
                            </tr>
                            <tr>
                                <td class="opacity-70 pr-10 h-8 align-top">Атрибуты</td>
                                <td class="align-top">
                                    <ul class="attribute-list">
                                    </ul>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit product modal -->
    <div id="edit-product-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative px-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-dark-gray shadow">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 pt-6">
                    <div class="title text-[20px] font-bold text-white">
                        <h3>
                            Редактировать продукт
                        </h3>
                    </div>
                    <button type="button"
                            data-modal-hide="edit-product-modal"
                            class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Закрыть окно</span>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="px-4 text-white min-h-[380px]">
                    <div class="modal-loader absolute top-1/2 right-1/2" role="status">
                        <svg aria-hidden="true"
                             class="w-8 h-8 relative top-[-8px] left-[8px] text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                             viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor"/>
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                    <div class="modal-content">
                        <form id="edit-product-form" class="product-form" action="/" method="post">

                            <div class="errors text-red-600 text-sm">
                            </div>
                            <label class="text-[10px]" for="article">Артикул</label>
                            <input class="block min-w-[75%] h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400 disabled:opacity-50"
                                   name="article" id="article" type="text"
                                   @cannot('update-product-article')
                                       disabled
                                @endcannot
                            >
                            <label class="text-[10px]" for="name">Название</label>
                            <input class="block min-w-[75%] h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400"
                                   name="name" id="name" type="text" required>
                            <label class="text-[10px]" for="status">Статус</label>

                            <select name="status" id="status"
                                    class="text-sm font-light block min-w-[75%] h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400 py-0">
                                <option value="available">Доступен</option>
                                <option value="unavailable">Недоступен</option>
                            </select>
                            <div class="text-[14px] font-bold block mt-3">Атрибуты</div>

                            <div class="hidden product-attribute w-[75%] mt-4">
                            </div>

                            <button type="button"
                                    class="add-attribute-btn text-xs text-ultra-sky-400 border-dashed border-b border-ultra-sky-400 mt-4">
                                + Добавить атрибут
                            </button>

                            <div class="flex items-center mt-8 pb-8">
                                <button
                                    class="submit-button inline-block font-sans text-white bg-ultra-sky-400 hover:bg-ultra-sky-500 font-medium rounded-lg px-11 py-2 text-[11px]">
                                    <svg aria-hidden="true" role="status"
                                         class="hidden inline w-6 h-4 me-3 text-white animate-spin relative left-1"
                                         viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="#E5E7EB"/>
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentColor"/>
                                    </svg>
                                    <span class="title">Сохранить</span>
                                </button>
                            </div>
                        </form>

                        <div class="attribute-template hidden flex items-center mt-2">
                            <div class="mr-3">
                                <label class="text-sm">
                                    Название
                                    <input
                                        name="attribute-name"
                                        class="block h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400"
                                        type="text" required>
                                </label>
                            </div>
                            <div class="mr-3">
                                <label class="text-sm">
                                    Значение
                                    <input
                                        name="attribute-val"
                                        class="block h-9 text-dark-gray rounded-md mt-1 focus:ring-ultra-sky-400"
                                        type="text" required>
                                </label>
                            </div>
                            <button class="btn-icon-delete relative top-[14px] right-1 w-6 h-9" type="button"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
