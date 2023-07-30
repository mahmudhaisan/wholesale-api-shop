<template>
    <div class="flex justify-center items-center h-screen">
      <form @submit.prevent="placeOrder" class="w-96 p-4 bg-white rounded-lg shadow-md">
        <!-- Select Category -->
        <div class="mb-4">
          <label for="category" class="block font-semibold mb-2">Select a Category</label>
          <select v-model="selectedCategory" @change="loadProducts" id="category" class="w-full border border-gray-300 rounded-md p-2">
            <option v-for="category in categories" :key="category" :value="category">{{ category }}</option>
          </select>
        </div>
  
        <!-- Select Product -->
        <div class="mb-4">
          <label for="product" class="block font-semibold mb-2">Select a Product</label>
          <select v-model="selectedProduct" id="product" class="w-full border border-gray-300 rounded-md p-2">
            <option v-for="product in filteredProducts" :key="product.id" :value="product.name">{{ product.name }}</option>
          </select>
        </div>
  
        <!-- Other product options can be added here -->
  
        <!-- Place Order Button -->
        <button type="submit" class="w-full bg-blue-500 text-white font-semibold rounded-md py-2">
          Place Order
        </button>
      </form>
    </div>
  </template>
  
  <script setup>
    import { ref, reactive, onMounted } from 'vue';
  
    // Data
    const selectedCategory = ref('');
    const selectedProduct = ref('');
    const categories = ref([]);
    const productList = reactive([]); // Make sure productList is the actual array of product data fetched from the API
  
    // Fetch product data from the API
    const fetchProducts = async () => {
      try {
        // Simulated product data (replace this with your actual API fetch logic)
        const response = await fetch('https://api.sinaliteuppy.com/product');
        const productData = await response.json();
  
        productList.push(...productData);
  
        // Extract unique categories from the data
        categories.value = Array.from(new Set(productList.map(item => item.category)));
  
        // Initially, load the products based on the first category
        if (categories.value.length > 0) {
          selectedCategory.value = categories.value[0];
          loadProducts();
        }
      } catch (error) {
        console.error('Error fetching products:', error);
      }
    };
  
    // Filter products based on the selected category
    const filteredProducts = ref([]);
    const loadProducts = () => {
      filteredProducts.value = productList.filter(item => item.category === selectedCategory.value);
      selectedProduct.value = ''; // Reset the selected product when the category changes
    };
  
    // Place Order Method
    const placeOrder = () => {
      // Handle the form submission here
      // You can access the selected category and product using the data variables above
      // For example:
      console.log('Selected Category:', selectedCategory.value);
      console.log('Selected Product:', selectedProduct.value);
    };
  
    onMounted(fetchProducts);
  </script>
  
  <style>
    /* Customize your styles here if needed */
  </style>
  