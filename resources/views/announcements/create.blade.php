<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-10">

        <div class="max-w-3xl mx-auto">

            <div class="bg-white shadow rounded-2xl p-8">

                <h1 class="text-3xl font-bold mb-6">
                    Buat Pengumuman
                </h1>

                <form action="{{ route('announcements.store') }}"
                    method="POST"
                    class="space-y-5">

                    @csrf

                    <div>

                        <label class="block mb-2 font-semibold">
                            Judul
                        </label>

                        <input type="text"
                            name="title"
                            class="w-full border border-gray-300 rounded-xl p-3 focus:ring focus:ring-blue-200">

                    </div>

                    <div>

                        <label class="block mb-2 font-semibold">
                            Isi Pengumuman
                        </label>

                        <textarea
                            name="content"
                            rows="6"
                            class="w-full border border-gray-300 rounded-xl p-3 focus:ring focus:ring-blue-200"></textarea>

                    </div>

                    <button
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl">

                        Publish

                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>