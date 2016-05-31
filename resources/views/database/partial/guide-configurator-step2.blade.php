<div class="modal-body">
    <label>1. What type of application will the laser system be used for?</label>
    <div>
        <input type="radio" name="question_first" value="visual" ng-model="dataInput.question_first"> Visual
        <input type="radio" name="question_first" value="dimensional" ng-model="dataInput.question_first"> Dimensional
    </div>
    <label>2. What is the expected frequency of user?</label>
    <div>
        <input type="radio" name="question_second" value="occasional" ng-model="dataInput.question_second"> Occasional
        <input type="radio" name="question_second" value="one_shift" ng-model="dataInput.question_second"> One Shift (8-10 hours per day)
        <input type="radio" name="question_second" value="continuous" ng-model="dataInput.question_second"> Continuous 24/7
    </div>
    <label>3. What is your most important to you?</label>
    <div>
        <input type="radio" name="question_third" value="budget" ng-model="dataInput.question_third"> Budget
        <input type="radio" name="question_third" value="blanced_budget" ng-model="dataInput.question_third"> Blanced budget & productivity
        <input type="radio" name="question_third" value="productivity" ng-model="dataInput.question_third"> Productivity
    </div>
</div>