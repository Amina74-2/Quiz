<script setup>
import { Link , usePage } from '@inertiajs/vue3';
import NewQuestionModal from '../shared/NewQuestionModal.vue';
import {computed , ref} from 'vue';
const page1=usePage();
const result=ref(0);
const appName=computed(()=>page1.props.appName);
const props=defineProps({
questions:Object
})
const selectedAnswer=ref(null);
const currentIndex=ref(0);
const totalQuestions=computed(()=>props.questions.length)
const currentQuestion=computed(()=>{
  return props.questions[currentIndex.value]
})
const islastQuestion=computed(()=>currentIndex.value===props.questions.length-1)
const answers=computed(()=>{
  return  props.questions[currentIndex.value].reponses
})
function selectedOption(index){
selectedAnswer.value=index

}
function nextQuestion(){
if(selectedAnswer.value !== null){
if(props.questions[currentIndex.value].reponses[selectedAnswer.value]){
result.value++;
}
currentIndex.value++;
selectedAnswer.value=null;
}
}
function submitting(){
  return alert('thank you , your result will be sent to the medecin');
}

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

<div class="mt-3 d-flex justify-content-center"><strong>Question {{ currentIndex+1 }} out of {{ totalQuestions }}</strong></div>

  <div class="d-flex flex-column flex-md-row p-4 gap-4 py-md-5 align-items-center justify-content-center">
   
    <div class="list-group">
    
    <a href="#" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
      
      <div class="d-flex gap-2 w-100 justify-content-between">
        <div>
          <h6 class="mb-0">{{currentQuestion.question}}</h6>
        </div>
      </div>
    </a>
    <a @click="selectedOption(index)" v-for="(answer,index) in answers" :class="{'selected':index===selectedAnswer}"  class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
     
      <div class="d-flex gap-2 w-100 justify-content-between">
        <div >
          
          <p class="mb-0 opacity-75">{{ answer.reponse}}</p>
        </div>
      </div>
    </a>
    
  </div>
  
</div>
<div class="d-flex justify-content-center">
  <button @click="nextQuestion" v-if="!islastQuestion" class="btn custom-primary">Next</button>
  <button  @click="submitting()" v-if="islastQuestion" class="btn btn-success ml-2">Submit</button>

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

.custom-primary {
  background-color: #9b6df2; 
  color: #fff; 
}
.selected{
  background-color: #9b6df2;
  color:white;
}
</style>
