<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            API Tokens
        </h2>
    </x-slot>

    <div id="app">
        <x-container class="py-8">

            {{-- Create access token --}}
            <x-form-section class="mb-12">
                <x-slot name="title">
                    Access Token
                </x-slot>

                <x-slot name="description">
                    Aquí podrás generar un Access Token
                </x-slot>

                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-4">
                        <div v-if="form.errors.length > 0"
                            class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <strong class="font-bold">¡Whoops!</strong>
                            <span>¡Algo salió mal!</span>

                            <ul>
                                <li v-for="error in form.errors">
                                    @{{ error }}
                                </li>
                            </ul>
                        </div>
                        <div>
                            <x-label>
                                Nombre
                            </x-label>

                            <x-input v-model="form.name" type="text" class="w-full mt-1" />
                        </div>

                        <div class="mt-4" v-if="scopes.length > 0">
                            <x-label class="mb-1">
                                Scopes
                            </x-label>

                            <div v-for="scope in scopes">
                                <x-label>
                                    <input
                                        type="checkbox" name="scopes" :value="scope.id" v-model="form.scopes"
                                        class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    >
                                    <span class="ml-1">@{{ scope.id }}</span>
                                </x-label>
                            </div>
                        </div>
                    </div>
                </div>

                <x-slot name="actions">
                    <x-button v-on:click="store" v-bind:disabled="form.disabled">
                        Crear
                    </x-button>
                </x-slot>
            </x-form-section>

            {{-- Show Access Tokens --}}
            <x-form-section v-if="tokens.length > 0">
                <x-slot name="title">
                    Lista de Access Tokens
                </x-slot>

                <x-slot name="description">
                    Aquí podrás encontrar todos los Access Tokens Creados
                </x-slot>

                <div>
                    <table class="text-gray-600">
                        <thead class="border-b border-gray-300">
                            <tr class="text-left">
                                <th class="py-2 w-full">Nombre</th>
                                <th class="py-2">Acción</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-300">
                            <tr v-for="token in tokens">
                                <td class="py-2">@{{ token.name }}</td>
                                <td class="flex divide-x divide-gray-300 py-2">
                                    <a v-on:click="show(token)" class="pr-2 hover:text-green-600 font-semibold cursor-pointer">
                                        Ver
                                    </a>

                                    <a class="pl-2 hover:text-red-600 font-semibold cursor-pointer"
                                        v-on:click="revoke(token)">
                                        Eliminar
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-form-section>
        </x-container>

        {{-- Modal (Show) --}}
        <x-dialog-modal modal="showToken.open">
            <x-slot name="title">
                Mostrar Access Token
            </x-slot>

            <x-slot name="content">
                <div class="space-y-2 overflow-auto">
                    <p>
                        <span class="font-semibold">Access Token: </span>
                        <span v-text="showToken.id"></span>
                    </p>
                </div>
            </x-slot>

            <x-slot name="actions">
                <button v-on:click="showToken.open = false" type="button"
                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50">
                    Cancelar
                </button>
            </x-slot>
        </x-dialog-modal>
    </div>

    @push('js')
        <script>
            new Vue({
                el: '#app',
                data: {
                    tokens: [],
                    scopes: [],
                    form: {
                        name: '',
                        scopes: [],
                        errors: [],
                        disabled: false
                    },
                    showToken: {
                        open: false,
                        id: ''
                    }
                },
                mounted() {
                    this.getScopes()
                    this.getTokens()
                },
                methods: {
                    async getScopes() {
                        try {
                            response = await axios.get('/oauth/scopes')
                            this.scopes = response.data
                        } catch (e) {
                            console.log(e.response.data)
                        }
                    },
                    async getTokens() {
                        try {
                            response = await axios.get('/oauth/personal-access-tokens')
                            this.tokens = response.data
                        } catch (e) {
                            console.log(e.response.data)
                        }
                    },
                    show(token) {
                        this.showToken.open = true,
                        this.showToken.id = token.id
                    },
                    store() {
                        this.form.disabled = true
                        axios.post('/oauth/personal-access-tokens', this.form)
                            .then(response => {
                                this.form.name = ''
                                this.form.errors = [],
                                this.form.scopes = [],
                                this.form.disabled = false

                                this.getTokens()
                            })
                            .catch(e => {
                                this.form.errors = _.flatten(_.toArray(e.response.data.errors))
                                this.form.disabled = false
                            })
                    },
                    revoke(token) {
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "¡No podrás revertir esta acción!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '¡Si, revóquelo sin miedo!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                axios.delete(`/oauth/personal-access-tokens/${token.id}`)
                                    .then(res => {
                                        this.getTokens()
                                    })

                                Swal.fire(
                                    '¡Rovocado!',
                                    'Su access token ya no funcionará.',
                                    'success'
                                )
                            }
                        })
                    }
                }
            })
        </script>
    @endpush

</x-app-layout>
