<x-admin-layout>

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-purple-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900">₱24,580</p>
                <p class="text-sm text-gray-500 mt-1">vs last month</p>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-green-500 font-semibold text-sm">+12.5%</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 7v1m-5 0h1m-1-4h1m8-4h1m-1 4h1m-2.599-4C10.92 6.402 10 5.42 10 4.5 10 3.58 10.92 3 12 3s2 .58 2 1.5c0 .92-.92 1.901-2.599 2.599z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-green-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900">1,247</p>
                <p class="text-sm text-gray-500 mt-1">vs last month</p>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-green-500 font-semibold text-sm">+8.2%</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-indigo-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">New Customers</p>
                <p class="text-3xl font-bold text-gray-900">332</p>
                <p class="text-sm text-gray-500 mt-1">vs last month</p>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-green-500 font-semibold text-sm">+15.2%</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg flex items-start justify-between border-t-4 border-yellow-500">
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Products Sold</p>
                <p class="text-3xl font-bold text-gray-900">8,847</p>
                <p class="text-sm text-gray-500 mt-1">vs last month</p>
            </div>
            <div class="flex flex-col items-end">
                <span class="text-red-500 font-semibold text-sm">-2.1%</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500 opacity-70 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Sales Overview</h2>
                    <select class="border border-gray-300 rounded-lg p-2 text-sm focus:ring-purple-500 focus:border-purple-500">
                        <option>Last 7 days</option>
                        <option>Last 30 days</option>
                        <option>Last 3 months</option>
                    </select>
                </div>
                <div class="h-64 flex flex-col justify-end relative">
                    <div class="absolute inset-y-0 left-0 w-12 text-xs text-gray-500">
                        <span class="absolute top-0 right-0">7,000</span>
                        <span class="absolute top-1/5 right-0">6,000</span>
                        <span class="absolute top-2/5 right-0">5,000</span>
                        <span class="absolute top-3/5 right-0">4,000</span>
                        <span class="absolute top-4/5 right-0">3,000</span>
                        <span class="absolute bottom-0 right-0">0</span>
                    </div>

                    <div class="w-full h-56 pl-12">
                        <svg viewBox="0 0 100 50" preserveAspectRatio="none" class="w-full h-full">
                            <path d="M0 45 L10 30 L20 38 L30 25 L40 28 L50 15 L60 20 L70 5 L80 8 L90 0 L100 8 V50 H0 Z" fill="#eff6ff" stroke="none" />
                            <path d="M0 45 L10 30 L20 38 L30 25 L40 28 L50 15 L60 20 L70 5 L80 8 L90 0 L100 8" fill="none" stroke="#6366f1" stroke-width="1.5" vector-effect="non-scaling-stroke" />
                        </svg>
                    </div>

                    <div class="flex justify-between text-xs text-gray-500 mt-2 pl-12">
                        <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Recent Orders</h2>
                    <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All Orders</a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ORDER ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CUSTOMER</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">PRODUCT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AMOUNT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600">#3847</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-sm font-semibold text-blue-600 mr-3">JO</div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">John Davis</p>
                                            <p class="text-sm text-gray-500">john.davis@email.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Premium Dog Food</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱89.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600">#3846</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-pink-100 flex items-center justify-center text-sm font-semibold text-pink-600 mr-3">EM</div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Emma Martinez</p>
                                            <p class="text-sm text-gray-500">emma.martinez@email.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Cat Toy Bundle</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱34.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Processing</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-600">#3845</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center text-sm font-semibold text-red-600 mr-3">RJ</div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">Robert Johnson</p>
                                            <p class="text-sm text-gray-500">robert.johns@email.com</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Bird Cage</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₱129.99</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Shipped</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 space-y-6">

    <div class="bg-white p-6 rounded-xl shadow-lg">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Popular Categories</h2>
            <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">View All</a>
        </div>
        
        <div class="flex justify-center items-center h-56 relative mb-4">
            <div class="absolute w-48 h-48 rounded-full" style="background: conic-gradient(
                #60a5fa 0% 30%,    /* Blue (Cat Food) */
                #6ee7b7 30% 60%,    /* Mint Green (Accessories) */
                #fcd34d 60% 80%,    /* Yellow/Orange (Dog Toys) */
                #fb923c 80% 100%   /* Orange/Red (Bird/Others) */
            );">
                <div class="absolute inset-8 bg-white rounded-full"></div>
            </div>
        </div>

        <div class="space-y-2 text-sm">
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: #60a5fa;"></span>
                <span class="text-gray-700 font-medium">Cat Food</span>
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: #6ee7b7;"></span>
                <span class="text-gray-700 font-medium">Accessories</span>
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: #fcd34d;"></span>
                <span class="text-gray-700 font-medium">Dog Toys</span>
            </div>
            <div class="flex items-center">
                <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: #fb923c;"></span>
                <span class="text-gray-700 font-medium">Bird & Goodies</span>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
        <div class="space-y-3">
            <a href="#" class="flex items-center justify-between p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition duration-150 ease-in-out">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-500 rounded-full text-white mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Add New Product</p>
                        <p class="text-xs text-gray-500">Create a new product listing</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <a href="#" class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-lg transition duration-150 ease-in-out">
                <div class="flex items-center">
                    <div class="p-2 bg-green-500 rounded-full text-white mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944c-3.195 0-6.236 1.282-8.485 3.531C1.282 8.764 0 11.805 0 15c0 3.195 1.282 6.236 3.531 8.485C5.764 25.718 8.805 27 12 27c3.195 0 6.236-1.282 8.485-3.531C22.718 21.236 24 18.195 24 15c0-3.195-1.282-6.236-3.531-8.485z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Process Orders</p>
                        <p class="text-xs text-gray-500">Review pending orders</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>

            <a href="#" class="flex items-center justify-between p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition duration-150 ease-in-out">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-500 rounded-full text-white mr-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.02.046 1.512.153a2.25 2.25 0 011.614 1.586A2.24 2.24 0 0017 6v2.25c0 .512-.046 1.02-.153 1.512a2.25 2.25 0 01-1.586 1.614A2.24 2.24 0 0012.75 12H7.5m4.75 4h-2.5m1.25-1.25V17m-1.25-1.25v2.5M12 12V3m0 9v7.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">Create Promotion</p>
                        <p class="text-xs text-gray-500">Set up discount codes</p>
                    </div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

</div>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="#" class="flex items-center justify-between p-4 bg-purple-50 hover:bg-purple-100 rounded-lg transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-500 rounded-full text-white mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Add New Product</p>
                                <p class="text-xs text-gray-500">Create a new product listing</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="#" class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-lg transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-500 rounded-full text-white mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944c-3.195 0-6.236 1.282-8.485 3.531C1.282 8.764 0 11.805 0 15c0 3.195 1.282 6.236 3.531 8.485C5.764 25.718 8.805 27 12 27c3.195 0 6.236-1.282 8.485-3.531C22.718 21.236 24 18.195 24 15c0-3.195-1.282-6.236-3.531-8.485z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Process Orders</p>
                                <p class="text-xs text-gray-500">Review pending orders</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>

                    <a href="#" class="flex items-center justify-between p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg transition duration-150 ease-in-out">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-500 rounded-full text-white mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.02.046 1.512.153a2.25 2.25 0 011.614 1.586A2.24 2.24 0 0017 6v2.25c0 .512-.046 1.02-.153 1.512a2.25 2.25 0 01-1.586 1.614A2.24 2.24 0 0012.75 12H7.5m4.75 4h-2.5m1.25-1.25V17m-1.25-1.25v2.5M12 12V3m0 9v7.5" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800">Create Promotion</p>
                                <p class="text-xs text-gray-500">Set up discount codes</p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>

    </div>

</x-admin-layout>