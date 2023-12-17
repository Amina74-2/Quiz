<script setup>
import { Link , usePage } from '@inertiajs/vue3';
import {computed} from 'vue';
const page1=usePage();
const appName=computed(()=>page1.props.appName);
</script>

<template>
  <div>
    <Header>
    <div class="col-md-3 mb-2 mb-md-0">
      <Link href="/" class="d-inline-flex link-body-emphasis">
        <span class="fs-4">{{ appName }}</span>
      </Link>
    </div>
    <ul class="custom-nav">
  <li class="nav-item"><Link href="/" :class="{'header-nav-link active': $page.url === '/', 'header-nav-link': $page.url !== '/'}">Home</Link></li>
  <li class="nav-item"><Link href="/questions" :class="{'header-nav-link active': $page.url === '/questions', 'header-nav-link': $page.url !== '/questions'}">Questions</Link></li>
  <li class="nav-item"><Link href="/quiz" :class="{'header-nav-link active': $page.url === '/quiz', 'header-nav-link': $page.url !== '/quiz'}">Quiz</Link></li>
    </ul>
    </Header>
  </div>

  <div class="px-4 py-5 my-5 text-center">
   
    <h1 class="display-5 fw-bold text-body-emphasis">Gaming Addiction Management Platform</h1>
<div class="col-lg-6 mx-auto">
  <p class="lead mb-4">We're here to help and  support you on your journey to a balanced and healthy digital life.             Click the button below to begin the assessment.</p>

      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <Link href="/quiz" class="btn btn-purple btn-lg px-4 gap-3">Start Quiz</Link>

      </div>
    </div>
  </div>
</template>

<style scoped>
  .custom-nav {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center; 
  }

  .header-nav-link {
    color: #9b6df2;
    text-decoration: none;
    padding: 10px;
    margin-right: 15px;
    font-weight: bold; /* Make the text bold */
  }

  .header-nav-link.active {
    border-bottom: 2px solid #9b6df2;
  }

  .header-nav-link:hover {
    text-decoration: underline;
  }

  

  .main-title {
    color: #333;
    font-size: 24px;
    margin-top: 20px;
    text-align: center; /* Center the text horizontally */
  }

  .table-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh; /* Optionally, set a height to center vertically in the viewport */
  }

 
.btn-purple {
  background-color: #9b6df2; /* Set the background color to purple */
  color: white; /* Set the text color to white */
}

</style>

