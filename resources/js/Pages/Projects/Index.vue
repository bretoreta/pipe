<template>
	<app-layout>
		<div class="pt-5 relative">
			<transition
				enter-active-class="transition ease-in duration-150"
				leave-active-class="transition ease-in-out duration-1000"
				enter-class="transform translate-x-10"
				leave-from-class="opacity-100"
				leave-to-class="opacity-0"
			>
				<div
					v-if="errorFlag"
					class="errors__display absolute top-2 right-8"
				>
					<div class="bg-red-500 py-4 px-6 rounded shadow-2xl max-w-sm">
						<div class="flex items-center">
							<p class="text-white text-sm font-bold">{{ errors }}</p>
							<button
								@click="errorFlag = false"
								class="icon px-3 py-1 rounded-md duration-200 text-red-800 ml-4 hover:text-white hover:bg-red-900"
							>
								X
							</button>
						</div>
					</div>
				</div>
			</transition>
			<transition
				enter-active-class="transition ease-in duration-1000"
				leave-active-class="transition ease-in-out duration-1000"
				enter-class="transform translate-x-10"
				leave-from-class="opacity-100"
				leave-to-class="opacity-0"
			>
				<div
					v-if="successFlag"
					class="success__display absolute top-2 right-8"
				>
					<div class="bg-green-500 py-4 px-6 rounded shadow-2xl max-w-sm">
						<div class="flex items-center">
							<p class="text-white text-sm font-bold">{{ $page.props.flash.message ?? 'Operation executed successfully' }}</p>
							<button
								@click="successFlag = false"
								class="icon px-3 py-1 rounded-md duration-200 text-green-800 ml-4 hover:text-white hover:bg-green-900"
							>
								X
							</button>
						</div>
					</div>
				</div>
			</transition>
			<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<div class="bg-gray-900 overflow-hidden sm:rounded-lg">
					<div class="w-full bg-gray-900 pl-10 pt-5 bloxk md:flex">
						<div class="w-full md:w-1/3">
							<div class="my-5">
								<p class="text-xl text-white">Hi {{$page.props.user.name}}</p>
								<span class="text-gray-500 uppercase text-sm">Let's make projects amazing!</span>
							</div>
							<div class="pb-5 w-full">
								<div class="title pb-3 pr-6 flex items-center justify-between">
									<p class="text-sm text-white font-bold uppercase">Projects <span class="text-gray-500 text-sm">({{ projects.length }})</span></p>
									<button
										@click="addingProject = true"
										class="text-sm uppercase font-bold px-2 py-1 bg-gray-700 hover:bg-gray-800 border-none rounded shadow-md text-white duration-200"
									>
										Add Project
									</button>
								</div>
								<div class="project__item__container flex flex-wrap w-full pr-5">
									<div
										v-for="project in projects"
										:key="project.id"
										class="w-1/3 h-32 p-2"
									>
										<div class="h-full transform duration-200 hover:-rotate-3 bg-gradient-to-b from-green-500 to-green-700 text-white rounded shadow-lg relative">
											<project-item
												:project="project"
												@getTasks="setActiveProject(project.id)"
											/>
											<div
												class="absolute -top-1 -right-1 p-2 bg-yellow-500 rounded-full shadow-lg"
												v-if="isActive(project.id)"
											></div>
										</div>
									</div>

									<!-- Dialog Modal for adding projects -->
									<dialog-modal
										:show="addingProject"
										:closeable="true"
										@close="closeModal"
									>
										<template #title>
											<div class="bg-gray-800 p-4 rounded">
												<div class="text-lg text-white font-bold">
													Add Project
												</div>
											</div>
										</template>
										<template #content>
											<form @submit.prevent="createProject">
												<div class="pb-3 text-gray-500">
													Enter the details requested below to add a new
													project
												</div>
												<div class="mt-4">
													<jet-label
														for="title"
														value="Title"
													/>
													<jet-input
														id="title"
														type="text"
														v-model="form.title"
														class="mt-1 block w-full"
														required
													/>
												</div>
												<div class="mt-4">
													<jet-label
														for="description"
														value="Description"
													/>
													<jet-input
														id="description"
														type="text"
														v-model="form.description"
														class="mt-1 block w-full"
														required
													/>
												</div>
												<div class="mt-4">
													<jet-label
														for="color"
														value="Color"
													/>
													<jet-input
														id="color"
														type="color"
														v-model="form.color"
														class="mt-1 block w-full"
														required
													/>
												</div>

												<div class="flex mt-5 space-x-4 justify-end">
													<danger-button @click="closeModal">Cancel</danger-button>
													<jet-button
														:class="{
																'opacity-25': form.processing,
															}"
														:disabled="form.processing"
													>Add Project</jet-button>
												</div>
											</form>
										</template>
									</dialog-modal>
									<!-- End of dialogue modal -->

								</div>
							</div>
						</div>
						<div class="w-full md:w-2/3">
							<div
								v-if="!projectTasks"
								class="py-4 px-6 bg-indigo-200 text-indigo-600 text-sm font-bold rounded-tl-2xl rounded-bl-2xl"
							>
								Select a project to view and manage your tasks...
							</div>
							<div
								v-if="projectTasks"
								class="bg-white rounded-tl-xl rounded-bl-xl py-8"
							>
								<task-items
									:tasks="projectTasks"
									@addTask="showAddTaskModal"
									@actionComplete="fetchFreshTasks"
								/>
							</div>
							<!-- Modal for adding task -->
							<dialog-modal
								:show="addingTask"
								:closeable="true"
								@close="closeModal2"
							>
								<template #title>
									<div class="bg-gray-800 rounded p-4">
										<div class="text-lg text-white font-bold">
											Add Task
										</div>
									</div>
								</template>
								<template #content>
									<div>
										<div class="pb-3 text-gray-500">
											Enter the details requested below to add a new
											task to the selected project
										</div>
										<div class="mt-4">
											<jet-label
												for="name"
												value="Name"
											/>
											<jet-input
												id="name"
												type="text"
												v-model="task.name"
												class="mt-1 block w-full"
												required
											/>
										</div>
										<div class="mt-4">
											<jet-label
												for="description"
												value="Description"
											/>
											<jet-input
												id="description"
												type="text"
												v-model="task.description"
												class="mt-1 block w-full"
												required
											/>
										</div>

										<div class="flex mt-5 space-x-4 justify-end">
											<danger-button @click="closeModal2">Cancel</danger-button>
											<jet-button @click="submitTask">Add Task</jet-button>
										</div>
									</div>
								</template>
							</dialog-modal>
							<!-- End of modal for adding task -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</app-layout>
</template>

<script>
	import AppLayout from "@/Layouts/AppLayout";
	import ProjectItem from "../../components/ProjectItem.vue";
	import Button from "../../Jetstream/Button.vue";
	import DialogModal from "../../Jetstream/DialogModal.vue";
	import DangerButton from "../../Jetstream/DangerButton.vue";
	import JetLabel from "../../Jetstream/Label.vue";
	import JetInput from "../../Jetstream/Input.vue";
	import JetButton from "../../Jetstream/Button";
	import TaskItems from "../../components/TaskItems.vue";

	export default {
		components: {
			AppLayout,
			ProjectItem,
			Button,
			DialogModal,
			DangerButton,
			JetLabel,
			JetInput,
			JetButton,
			TaskItems,
		},
		props: ["projects"],
		data() {
			return {
				form: this.$inertia.form({
					title: "",
					color: null,
					description: "",
				}),
				task: {
					name: "",
					description: "",
				},

				errorFlag: false,
				successFlag: false,
				errors: null,
				activeProject: null,
				projectTasks: null,
				addingProject: false,
				addingTask: false,
			};
		},
		mounted() {
			this.activeProject = sessionStorage.getItem('activeProject') ?? null;

			if(this.activeProject) this.getActiveProjectTasks(this.activeProject);
		},
		methods: {
			closeModal() {
				this.addingProject = false;

				this.form.reset();
			},
			closeModal2() {
				this.addingTask = false;

				this.task.name = "";
				this.task.description = "";
			},
			showAddTaskModal() {
				this.addingTask = true;
			},
			isActive(id) {
				return id == this.activeProject ? true : false;
			},
			setActiveProject(id) {
				this.activeProject = id;
				sessionStorage.setItem('activeProject', id);

				this.getActiveProjectTasks(id);
			},
			fetchFreshTasks() {
				this.getActiveProjectTasks(this.activeProject);
			},
			getActiveProjectTasks(id) {
				axios
					.get("/project/" + id + "/tasks")
					.then((response) => {
						this.errorFlag = false;
						this.projectTasks = response.data;
						this.successFlag = true;
					})
					.catch((errors) => {
						this.errorFlag = true;
						this.errors = errors.response.data.message;
					});
				setTimeout(() => {
					this.successFlag = false;
				}, 2000);
				setTimeout(() => {
					this.errorFlag = false;
				}, 2000);
			},
			createProject() {
				this.form.post(
					route("projects.index"),
					{
						onFinish: () => {
							this.closeModal(), (this.successFlag = true);
						},
					},
					{ preserveScroll: true, preserveState: true }
				);
				setTimeout(() => {
					this.successFlag = false;
				}, 2000);
				setTimeout(() => {
					this.errorFlag = false;
				}, 2000);
			},
			updateTask(taskId) {
				axios
					.put("/project/tasks/" + taskId, {
						id: this.activeProject,
						name: this.task.name,
						description: this.task.description,
					})
					.then(() => {
						this.successFlag = true;
					})
					.catch((errors) => {
						this.errorFlag = true;
						this.errors = errors.message;
					});

				this.getActiveProjectTasks(this.activeProject);
				this.closeModal3();
				setTimeout(() => {
					this.successFlag = false;
				}, 2000);
				setTimeout(() => {
					this.errorFlag = false;
				}, 2000);
			},
			submitTask() {
				axios
					.post("/project/task", {
						id: this.activeProject,
						name: this.task.name,
						description: this.task.description,
					})
					.then(() => {
						this.successFlag = true;
					})
					.catch((errors) => {
						this.errorFlag = true;
						this.errors = errors.message;
					});

				this.getActiveProjectTasks(this.activeProject);
				this.closeModal2();
				setTimeout(() => {
					this.successFlag = false;
				}, 2000);
				setTimeout(() => {
					this.errorFlag = false;
				}, 2000);
			},
		},
	};
</script>
<style scoped>
	.project__item__container {
		max-height: 500px;
		overflow-y: scroll;
	}
	.project__item__container::-webkit-scrollbar {
		display: none;
	}
</style>