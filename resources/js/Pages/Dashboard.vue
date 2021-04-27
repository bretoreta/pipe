<template>
    <app-layout>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="w-full bg-gray-900 shadow-lg px-10 py-5 flex">
                        <div class="w-1/3">
                            <p class="text-xl text-white">Hi {{$page.props.user.name}}</p>
                            <span class="text-gray-500 uppercase text-sm">Let's make projects amazing!</span>
                        </div>
                        <div class="w-2/3">
                            <div class="bg-white rounded-tl-xl rounded-bl-xl p-5">
                                Here is a list of your projects
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'

    export default {
        components: {
            AppLayout,
        },
    }
</script>
