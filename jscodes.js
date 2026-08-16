const cardNumber = document.querySelector(".number");
const numberInp = document.querySelector("#card-number");
const nameInp = document.querySelector("#card-name");
const cardName = document.querySelector(".name");
const cardMonth = document.querySelector(".month");
const cardYear = document.querySelector(".year");
const monthInp = document.querySelector("#card-month");
const yearInp = document.querySelector("#card-year");
const cardCvc = document.querySelector(".cvc");
const cvcInp = document.querySelector("#card-cvc");
const submitBtn = document.querySelector(".submit-button");
const completed = document.querySelector(".thanks");
const form = document.querySelector("form");

function setCardNumber(e) {
  cardNumber.innerText = format(e.target.value);
}

function setCardName(e) {
  cardName.innerText = format(e.target.value);
}

function setCardMonth(e) {
  cardMonth.innerText = format(e.target.value);
}

function setCardYear(e) {
  cardYear.innerText = format(e.target.value);
}

function setCardCvc(e) {
  cardCvc.innerText = format(e.target.value);
}

function handleSubmit(e) {
  e.preventDefault();
  
  const nameValue = nameInp.value.trim();
const onlyLettersAndSpaces = /^[A-Za-z\s]+$/;

if (!nameValue) {
  nameInp.classList.add('error');
  nameInp.parentElement.classList.add("errormessage");
} else if (!onlyLettersAndSpaces.test(nameValue)) {
  nameInp.classList.add("error");
  nameInp.parentElement.classList.remove("errormessage");
} else {
  nameInp.classList.remove("error");
  nameInp.parentElement.classList.remove("errormessage");
}



  if (!numberInp.value) {
    numberInp.classList.add('error')
    numberInp.parentElement.classList.add("errormessage");
  } else if (numberInp.value.length < 16) {
    numberInp.classList.add("error")
  } else {
    numberInp.classList.remove("error");
    numberInp.parentElement.classList.remove("errormessage");
  }

  if (!monthInp.value) {
    monthInp.classList.add("error");
    monthInp.parentElement.classList.add("errormessage");
  } else if (monthInp.value.length < 2) {
    monthInp.classList.add("error");
  } else {
    monthInp.classList.remove("error");
    monthInp.parentElement.classList.remove("errormessage");
  }
  
  if (!yearInp.value) {
    yearInp.classList.add("error");
    yearInp.parentElement.classList.add("errormessage");
  } else if (yearInp.value.length < 2 ) {
    yearInp.classList.add("error");
  } else {
    yearInp.classList.remove("error");
    yearInp.parentElement.classList.remove("errormessage");
  }
  

  if (!cvcInp.value) {
    cvcInp.classList.add("error");
    cvcInp.parentElement.classList.add("errormessage");
  } else if (cvcInp.value.length < 3 ) {
    cvcInp.classList.add("error");
  } else {
    cvcInp.classList.remove("error");
    cvcInp.parentElement.classList.remove("errormessage");
  }
  
  if (
    nameInp.value && 
    onlyLettersAndSpaces.test(nameValue)&&
    numberInp.value &&
    monthInp.value.length == 2 &&
    yearInp.value.length == 2 &&
    cvcInp.value.length == 3 &&
    numberInp.value.length == 16
  ) {
    completed.classList.remove("hidden");
    form.classList.add("hidden");
  }
}

function format(s) {
  return s.toString().replace(/\d{4}(?=.)/g, "$& ");
}

numberInp.addEventListener("keyup", setCardNumber);
nameInp.addEventListener("keyup", setCardName);
monthInp.addEventListener("keyup", setCardMonth);
yearInp.addEventListener("keyup", setCardYear);
cvcInp.addEventListener("keyup", setCardCvc);
submitBtn.addEventListener("click", handleSubmit);