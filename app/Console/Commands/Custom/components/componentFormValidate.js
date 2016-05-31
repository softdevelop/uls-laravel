var {componentModule} = angular.module('{component}');

{componentModule}.factory('{componentFormValidateService}', ['', function(){
    
    this.{formValidate}
    this.validationOptions = {
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: "We need your email address to contact you",
                email: "Your email address must be in the format of name@domain.com"
            },
            password: {
                required: "You must enter a password",
                minlength: "Your password must have a minimum length of 6 characters"
            }
        }
    }
    return this;
}]);
