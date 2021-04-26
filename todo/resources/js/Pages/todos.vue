<template>
    <app-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <center> <h2 class="font-semibold text-xl text-black-800 leading-tight">
                To Do List
            </h2></center><br>
    <center><button @click="openModal()" class="bg-blue-300 hover:bg-blue-500 text-black py-2 px-4 rounded my-3"><center><i class="fas fa-plus-square"></i>&nbsp Add New List</center></button></center>                        
    <br><table class="table-fixed w-full">
                        <thead>
                            <tr class="bg-green-100">
                                <th class="px-4 py-2">List</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in data" :key="row.id">
                                <td class="border px-4 py-2">{{row.name}}</td>
                                <td class="border px-4 py-2">
                                    <center><button @click="edit(row)" class="bg-yellow-300 hover:bg-yellow-500 text-black py-2 px-4 rounded"><center><i class="fas fa-pen"></i>&nbsp Edit</center></button>&nbsp;
                                    <button @click="deleteRow(row)" class="bg-red-300 hover:bg-red-500 text-black py-2 px-4 rounded"><center><i class="fas fa-trash"></i>&nbsp Delete</center></button></center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400" v-if="isOpen">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 transition-opacity">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                        
                            <!-- This element is to trick the browser into centering the modal contents. -->
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                <form>
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <div class="">
                                            <div class="mb-4">
                                                <label for="exampleFormControlInput1" class="block text-gray-700 text-sm font-bold mb-2">List:</label>
                                                <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="exampleFormControlInput1" placeholder="Enter List" v-model="form.name">
                                                
                                            </div>
                                        </div>
                                    </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-black shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" 
                                            v-show="!editMode" @click="save(form)">Add
                                    </button>
                                </span>
                                <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                                    <button wire:click.prevent="store()" type="button" class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-black shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5" 
                                            v-show="editMode" @click="update(form)">Update
                                    </button>
                                </span>
                                <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                                    <button @click="closeModal()" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-black-700 shadow-sm hover::text-gray-500 focus:outline-none focus::border-blue-300 focus::shadow-outline-blue transition ease-in-out- duration-150 sm:text-sm sm:leading-5">
                                        Cancel
                                    </button>
                                </span>
                            </div>
                                </form>
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>


<script>
import AppLayout from './../Layouts/AppLayout'
import Welcome from './../Jetstream/Welcome'
export default{
    components:{
        AppLayout,
        Welcome,
    },
    props: ['data','errors'],
    data(){
        return{
            editMode: false,
            isOpen:false,
            form:{
                name:null,
            },
        }
    },
    methods:{
        openModal:function(){
            this.isOpen = true;
        },
        closeModal:function(){
            this.isOpen = false;
            this.reset();
            this.editMode = false;
        },
        reset:function(){
            this.form = {
                name: null,
            }
        },
        save:function(data){
            this.$inertia.post('/todos',data)
            alert("List Successfully Added!");
            this.reset();
            this.closeModal();
            this.editMode = false;
        },
        edit:function(data){
            this.form = Object.assign({},data);
            this.editMode = true;;
            this.openModal();
        },
        update:function(data){
            data._method = "PUT";
            this.$inertia.post('/todos/' + data.id, data)
            alert("List Successfully Updated!");
            this.reset();
            this.closeModal();
        },
        deleteRow:function(data){
            if (!confirm('Are you sure you want to delete?')) return;
            data._method ="DELETE";
            this.$inertia.post('/todos/' + data.id, data)
            this.reset();
            this.closeModal()
        }

    }
}
</script>
