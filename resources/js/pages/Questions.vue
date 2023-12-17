<script setup>
import { Link, router } from '@inertiajs/vue3';
import NewQuestionModal from '../shared/NewQuestionModal.vue';
import {ref} from 'vue';
import {usePage} from '@inertiajs/vue3';
import {computed} from 'vue';
const page=usePage();
const reponses=ref([]);
const success=computed(()=>page.props.flash.success);
const showNewQuestionModal=ref(false);
const createdQuestion=ref(null);
const newAnswers=ref([]);
let AnswerId = 1;
const showViewQuestionModal=ref(false);
const selectedQuestion=ref(null);

const page1=usePage();
const appName=computed(()=>page1.props.appName);
function createQuestion(){
 showNewQuestionModal.value=true
}
function destroyModal(){
  showNewQuestionModal.value=false
  showViewQuestionModal.value=false
}
function addNewAnswer() {
  const newAnswer = {
    id: AnswerId++,
    answer: ""
  };

  newAnswers.value.push(newAnswer);
}
function submitQuestion(){
  if(!createdQuestion.value){
    alert ('Question can not be empty')
    return false
  }
  if(!validateAnswers()&& !answerCount()){
    alert ("fill all inputs before submitting")
    return false
  }
  router.post('/questions',{
    question:createdQuestion.value,
    answer:newAnswers.value
   

    } )
    router.on("success",()=>{
       createdQuestion.value=null,
       newAnswers.value=[]
    })
}
const props=defineProps({
  questions: Object,
  errors:Object,

}

);
function validateAnswers(){
  for (const answer of newAnswers.value){
    if(answer.answer.trim()===''){
      return false
    }
  }
  return true
}

function answerCount() {
  if (newAnswers.length < 2) {
    alert('2 answers or plus required to submit');
  } else if (newAnswers.length === 2) {
    return true;
  }
  return false;
}
function viewQuestion(index){
  showViewQuestionModal.value=true
  selectedQuestion.value=props.questions[index]
  reponses.value=props.questions[index].reponses;
   
    
}

//save updated answers to database
function updateAnswers(){
  router.put('/Reponses',
  reponses.value,
 
  )
}
//edit question 
const editquestionModal=ref(false);
const questionforedit=ref(null);
function editquestion(index){
  questionforedit.value=props.questions[index];
  
}
//update question
function updateQuestion(){
  router.put('/questions',
  questionforedit.value
  )
}
//delete question
function deleteQuestion(id){
 
 return router.delete('/questions/'+id)
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
    <button @click="createQuestion" class="button ">create</button>
    <div class="page-container">
      
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Question</th>
          <th scope="col">Action</th>
          
        </tr>
      </thead>
      <tbody>
        <tr v-for="(question,index) in questions">
          <th scope="row">{{ index+1}}</th>
          <td>{{question.question}}</td>
          <td>
            <button @click="viewQuestion(index)" class="btn custom-primary">View</button>
            <button @click="editquestionModal=true,editquestion(index)"  class="btn btn-success ">Edit</button>
            <button @click="deleteQuestion(question.id)" class="btn btn-danger ">Delete</button>
          </td>
         
        </tr>
        
      </tbody>
      
    </table>
  
    </div>
    <Teleport to="body">
      <NewQuestionModal :show="showNewQuestionModal" @close="destroyModal">
        <template #header>
<h5>Add new question </h5>

</template>
<template #success>
  <div v-if="success"  class="alert alert-success">{{success}}</div>
</template>
        <template #body>
          <form>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Question</label>
    <input type="text" v-model="createdQuestion" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">

  </div>
  </form>
  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Answers</th>
    
    </tr>
  </thead>
  <tbody>
    <tr  v-for="(answer, index) in newAnswers" :key="index"  >
      <th scope="row">{{ answer.id}}</th>
      <td> <input type="text " v-model="answer.answer" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
</td>
    </tr>
</tbody>
</table>

</template>
<template #footer>
  <span @click="addNewAnswer" v-if="newAnswers.length<6"><h2>+</h2></span>
<button @click="destroyModal" class=" btn btn-danger">close</button>

<button v-if="newAnswers.length>=2" @click="submitQuestion" class="btn btn-success">submit</button>
</template>

      </NewQuestionModal>

     
      <NewQuestionModal :show="showViewQuestionModal" @close="destroyModal">
<template #header>
<h5> view Question/Answers</h5>
</template>
<template #success>
  <div v-if="success"  class="alert alert-success">{{success}}</div>
</template>
<template #body>
  <p><strong>Q.{{ selectedQuestion.question }}</strong></p>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Answers</th>
      </tr>
    </thead>
    <tbody>
     <tr v-for="(answer,index) in reponses">
  <th scope="row">{{index+1}}</th>
  <td>
    <input type="text" v-model="answer.reponse" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </td>
</tr>
    </tbody>
  </table>
</template>
<template #footer>
<button  @click="updateAnswers()" class="btn btn-success">Update</button>
<button @click="destroyModal()" class="btn btn-danger">close</button>
</template>
      </NewQuestionModal>
      <NewQuestionModal :show="editquestionModal" @close="editquestionModal=false">
        <template #header>
<h5>Edit Question</h5>
        </template>
        <template #success>
  <div v-if="success"  class="alert alert-success">{{success}}</div>
</template>
<template #body>
  <form>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Question</label>
    <input   type="text" v-model="questionforedit.question" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  </form>
</template>
<template #footer>
  <button  @click="updateQuestion()" class="btn btn-success">Update</button>
<button @click="editquestionModal=false" class="btn btn-danger">close</button>
</template>
      </NewQuestionModal>
    </Teleport>
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
/*table*/
.page-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; /* Optionally, set a height to center vertically in the viewport */
}

.table {
  width: 80%; /* Adjust the width as needed */
  border-collapse: collapse;
  margin-top: 20px; /* Optional margin for spacing */
}

th, td {
  border: 1px solid #9b6df2;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #9b6df2;
  color: white;
}
/* Button styling */
.button {
  background-color: #9b6df2;
  color: white;
  padding: 5px 11px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.button:hover {
  background-color: #9b6df2; 
}
.custom-primary {
  background-color: #9b6df2; 
  color: #fff; 
}

</style>