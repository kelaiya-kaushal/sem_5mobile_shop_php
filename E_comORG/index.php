
<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileShop - Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
 
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            color: white;
            transition: all 0.3s;
        }
        
        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .dashboard-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        /* Interactive category cards */
        .category-card {
            transition: all 0.2s ease;
        }
        .category-card:hover {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .sidebar-item {
            transition: transform 0.2s ease;
        }
        .sidebar-item:hover {
            transform: translateX(5px);
        }
        
        .product-image {
            height: 120px;
            object-fit: contain;
            background-color: #f1f1f1;
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="sidebar w-64 flex-shrink-0 hidden md:block bg-gradient-to-b from-blue-600 to-cyan-500 text-white">
        <div class="p-4">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-bold">MobileShop Admin</h1>
                <button id="sidebarToggle" class="text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="mt-8 space-y-2">
                <a href="dashboard.php" class="flex items-center p-3 rounded-lg sidebar-item hover:bg-white hover:text-blue-700 transition">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="product.php" class="flex items-center p-3 rounded-lg sidebar-item hover:bg-white hover:text-blue-700 transition">
                    <i class="fas fa-mobile-alt mr-3"></i>
                    <span>Products</span>
                </a>
                <a href="order.php" class="flex items-center p-3 rounded-lg sidebar-item hover:bg-white hover:text-blue-700 transition">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    <span>Orders</span>
                </a>
                <a href="customer.php" class="flex items-center p-3 rounded-lg sidebar-item hover:bg-white hover:text-blue-700 transition">
                    <i class="fas fa-users mr-3"></i>
                    <span>Customers</span>
                </a>
                <a href="category.php" class="flex items-center p-3 rounded-lg sidebar-item hover:bg-white hover:text-blue-700 transition">
                    <i class="fas fa-tag mr-3"></i>
                    <span>Categories</span>
                </a>
                
            </div>
        </div>
    </div>
    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <!-- Top Navigation -->
        <header class="bg-white shadow-sm p-4 flex justify-between items-center">
            <div class="flex items-center">
                <button id="mobileSidebarToggle" class="md:hidden text-gray-600 mr-4 focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-lg font-semibold">Dashboard</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <i class="fas fa-bell text-gray-500"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center">3</span>
                </div>
                <div class="flex items-center">
                   <span class="capitalize"><?php echo $_SESSION['admin_name']; ?></span>
                    <i class="fas fa-chevron-down ml-2 text-gray-500"></i>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg p-6 shadow-sm dashboard-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500">Total Revenue</p>
                            <h3 class="text-2xl font-bold">$24,780</h3>
                        </div>
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-full">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                    <p class="text-green-500 text-sm mt-2"><i class="fas fa-arrow-up mr-1"></i> 12% from last month</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-sm dashboard-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500">Total Orders</p>
                            <h3 class="text-2xl font-bold">1,426</h3>
                        </div>
                        <div class="bg-green-100 text-green-600 p-2 rounded-full">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </div>
                    <p class="text-green-500 text-sm mt-2"><i class="fas fa-arrow-up mr-1"></i> 8% from last month</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-sm dashboard-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500">Total Products</p>
                            <h3 class="text-2xl font-bold">329</h3>
                        </div>
                        <div class="bg-purple-100 text-purple-600 p-2 rounded-full">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                    </div>
                    <p class="text-green-500 text-sm mt-2"><i class="fas fa-arrow-up mr-1"></i> 5 new this week</p>
                </div>
                <div class="bg-white rounded-lg p-6 shadow-sm dashboard-card">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-gray-500">Active Customers</p>
                            <h3 class="text-2xl font-bold">842</h3>
                        </div>
                        <div class="bg-yellow-100 text-yellow-600 p-2 rounded-full">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                    <p class="text-red-500 text-sm mt-2"><i class="fas fa-arrow-down mr-1"></i> 2% from last month</p>
                </div>
            </div>

            
           
                
                <!-- Top Selling Products -->
                
            <!-- Recent Orders & Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Orders -->
                <div class="bg-white p-6 rounded-lg shadow-sm col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-semibold">Recent Orders</h3>
                        <a href="#" class="text-blue-600 text-sm">View All</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600 cursor-pointer hover:underline" onclick="showOrderDetails('MS-7895')">#MS-7895</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">John Smith</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Delivered</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">$1,299.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Today, 10:45 AM</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">#MS-7894</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Sarah Johnson</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Shipped</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">$799.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Today, 9:30 AM</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">#MS-7893</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Michael Brown</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Processing</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">$599.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Yesterday, 4:20 PM</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">#MS-7892</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Emily Davis</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Pending</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">$1,099.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Yesterday, 2:15 PM</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-600">#MS-7891</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Robert Wilson</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Cancelled</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">$899.00</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">Dec 12, 2023</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-blue-50 transition-colors" onclick="showAddProductForm()">
                            <div class="bg-blue-100 text-blue-600 p-3 rounded-full mb-2">
                                <i class="fas fa-plus"></i>
                            </div>
                            <span class="text-sm">Add Product</span>
                        </button>
                       
                        <button class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-purple-50 transition-colors">
                            <div class="bg-purple-100 text-purple-600 p-3 rounded-full mb-2">
                                <i class="fas fa-chart-pie"></i>
                            </div>
                            <span class="text-sm">Add Brand</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-4 border rounded-lg hover:bg-yellow-50 transition-colors">
                            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-full mb-2">
                                <i class="fas fa-users"></i>
                            </div>
                            <span class="text-sm">Manage Users</span>
                        </button>
                    </div>
                    
                    <!-- Inventory Alerts -->
                    <div class="mt-8">
                        <h3 class="font-semibold mb-4">Low Stock Alerts</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                                <div class="flex items-center">
                                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/c23f1633-5429-42ff-b4f0-c09b015debef.png" alt="iPhone 15 Pro Max in gold color" class="w-8 h-8 rounded mr-2">
                                    <span class="text-sm">iPhone 15 Pro Max (Gold)</span>
                                </div>
                                <span class="text-red-500 text-sm font-medium">3 left</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div class="flex items-center">
                                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/4594d7e8-66cc-4b46-8bcd-ec7efe6990e8.png" alt="Samsung Galaxy Buds Pro 2 in black" class="w-8 h-8 rounded mr-2">
                                    <span class="text-sm">Galaxy Buds Pro 2 (Black)</span>
                                </div>
                                <span class="text-yellow-500 text-sm font-medium">5 left</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                                <div class="flex items-center">
                                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/208502e8-7922-479b-b4ac-6c30289c92ba.png" alt="Google Pixel Watch 2 with silver case" class="w-8 h-8 rounded mr-2">
                                    <span class="text-sm">Pixel Watch 2 (Silver)</span>
                                </div>
                                <span class="text-yellow-500 text-sm font-medium">7 left</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    