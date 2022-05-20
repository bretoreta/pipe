<template>
	<div class="pl-8 pr-16">
		<div class="tasks__container">
			<div class="tasks__header flex justify-between">
				<div class="left">
					<div class="text-3xl font-bold tracking-wide">Tasks</div>
					<div class="flex space-x-2 pt-1">
						<div class="bg-gray-200 py-1 w-16 rounded-full"></div>
						<div class="bg-green-500 py-1 w-16 rounded-full"></div>
					</div>
				</div>
				<div class="right">
					<button
						@click="$emit('addTask')"
						class="text-sm uppercase font-bold px-2 py-1 bg-green-600 hover:bg-green-800 border-none rounded shadow-md text-white duration-200"
					>Add Task</button>
				</div>
			</div>
			<div
				v-if="!tasks?.length"
				class="no__tasks pt-4"
			>
				<div class="text-sm uppercase p-4 bg-indigo-200 text-indigo-600">
					<p>There are no tasks defined for this project. Please add a task or delete this project.</p>
				</div>
			</div>
			<div v-if="tasks?.length > 0">
				<div class="info__text text-gray-500 text-sm pt-4">
					<p>Here are the tasks defined for the selected project. Feel free to manipulate the tasks as needed. All the tasks have been categorised by the completion level.</p>
				</div>
				<div class="inner__tasks__container mt-5">
					<div class="active__tasks bg-gray-100 p-3 border-b mb-2">
						<div class="text-xl font-bold">Active Tasks</div>
						<div class="individual__task pt-4">
							<div
								v-for="task in tasks"
								:key="task.id"
							>
								<div
									class="flex justify-between items-center py-1"
									v-if="task.stage == 1"
								>
									<div class="left flex items-center">
										<div class="border-2 border-green-500 p-1 rounded-full"></div>
										<p class="ml-2">{{ task.name }}</p>
									</div>
									<div class="right flex items-center space-x-2">
										<button
											@click="markTaskDone(task.id)"
											class="text-sm uppercase font-bold px-2 py-1 bg-gray-200 hover:bg-green-200 hover:text-green-600 duration-200"
										>Done</button>
										<button
											@click="deleteTask(task.id)"
											class="text-sm uppercase font-bold px-2 py-1 bg-gray-200 hover:bg-red-200 hover:text-red-600 duration-200"
										>Delete</button>
										<div class="status__text bg-green-200 text-green-600 py-1 px-3 rounded-full font-bold uppercase text-sm">In Progress</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="pending__tasks bg-gray-100 p-3 border-b mb-2">
						<div class="text-xl font-bold">Pending Tasks</div>
						<div class="individual__task pt-4">
							<div
								v-for="task in tasks"
								:key="task.id"
							>
								<div
									class="flex justify-between items-center py-1"
									v-if="task.stage == 0"
								>
									<div class="left flex items-center">
										<div class="border-2 border-green-500 p-1 rounded-full"></div>
										<p class="ml-2">{{ task.name }}</p>
									</div>
									<div class="right flex items-center space-x-2">
										<button
											@click="startTask(task.id)"
											class="text-sm uppercase font-bold px-2 py-1 bg-gray-200 hover:bg-indigo-200 hover:text-indigo-600 duration-200"
										>Start</button>
										<!-- <button @click="editTask(task)" class="text-sm uppercase font-bold px-2 py-1 bg-gray-200 hover:bg-green-200 hover:text-green-600 duration-200">Edit</button> -->
										<button
											@click="deleteTask(task.id)"
											class="text-sm uppercase font-bold px-2 py-1 bg-gray-200 hover:bg-red-200 hover:text-red-600 duration-200"
										>Delete</button>
										<div class="status__text bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full font-bold uppercase text-sm">Waiting</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="completed__tasks bg-gray-100 p-3 border-b mb-2">
						<div class="text-xl font-bold">Completed Tasks</div>
						<div class="individual__task pt-4">
							<div
								v-for="task in tasks"
								:key="task.id"
							>
								<div
									class="flex justify-between items-center py-1"
									v-if="task.stage == 11"
								>
									<div class="left flex items-center">
										<div class="border-2 border-green-500 p-1 rounded-full"></div>
										<p class="ml-2">{{ task.name }}</p>
									</div>
									<div class="right flex items-center space-x-2">
										<button
											@click="deleteTask(task.id)"
											class="text-sm uppercase font-bold px-2 py-1 bg-gray-200 hover:bg-red-200 hover:text-red-600 duration-200"
										>Delete</button>
										<div class="status__text bg-indigo-100 text-indigo-600 py-1 px-3 rounded-full font-bold uppercase text-sm">Complete</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		props: ["tasks"],
		emits: ["actionComplete", "addTask"],
		methods: {
			deleteTask(id) {
				if (confirm("Are you sure to delete this task?"))
					axios.delete("/project/tasks/" + id).then((response) => {
						this.$emit("actionComplete");
					});
			},
			markTaskDone(id) {
				if (confirm("Mark this task as done ?"))
					axios.post("/project/task/" + id + "/done").then((response) => {
						this.$emit("actionComplete");
					});
			},
			startTask(id) {
				if (confirm("Start this task? This action cannot be undone."))
					axios.post("/project/task/" + id + "/start").then((response) => {
						this.$emit("actionComplete");
					});
			},
			editTask(task) {
				this.$emit("editTask", task);
			}
		},
	};
</script>

<style scoped>
	.inner__tasks__container {
		max-height: 400px;
		overflow-y: scroll;
	}
	.inner__tasks__container::-webkit-scrollbar {
		display: none;
	}
</style>