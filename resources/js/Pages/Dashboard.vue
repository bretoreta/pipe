<template>
    <app-layout>
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full bg-gray-900 shadow-lg pl-10 pt-5 flex">
                    <div class="hidden md:block md:w-1/3">
                        <div class="my-5">
                            <p class="text-xl text-white">Hi {{$page.props.user.name}}</p>
                            <span class="text-gray-500 uppercase text-sm">Let's make projects amazing!</span>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3">
                        <div class="bg-indigo-200 text-indigo-600 text-sm font-bold rounded-tl-xl rounded-bl-xl py-4 px-6">
                            Here is an overview of your latest projects. Newest first
                        </div>
                    </div>
                </div>
                <div class="w-full mt-5">
                    <table class="w-full" v-if="projects.length > 0">
                        <tr>
                            <th class="bg-green-600 text-white p-4 text-sm font-bold uppercase text-left rounded-tl-xl">
                                Project Name
                            </th>
                            <th class="bg-green-600 text-white p-4 text-sm font-bold uppercase text-left">
                                Project Description
                            </th>
                            <th class="bg-green-600 text-white p-4 text-sm font-bold uppercase text-left rounded-tr-xl">
                                Number of Taks
                            </th>
                        </tr>
                        <tr v-for="project in projects" :key="project.id" class="bg-gray-800 text-white border-b border-green-600 hover:bg-gray-900 duration-200 cursor-pointer" @click="goToProject(project.id)">
                            <td class="px-4 py-3">{{project.title}}</td>
                            <td class="px-4 py-3">{{project.description}}</td>
                            <td class="px-4 py-3">{{project.tasks.length}}</td>
                        </tr>
                    </table>
                    <div v-else class="bg-yellow-400 text-white text-sm font-bold p-5 rounded">There are no projects for this account please <span class="text-yellow-900">Create One</span></div>
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
        props: ['projects'],
        methods: {
            goToProject(projectId) {
                sessionStorage.setItem("activeProject", projectId);
                this.$inertia.get('/projects');
            }
        },
    }
</script>
