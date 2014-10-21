<?php
class Backend_Account_ResetPasswordForm extends BaseForm
{
	public function configure()
	{
		$this->setWidgets(
			array(
				'password' => new sfWidgetFormInputPassword(
					array(),
					array(
							"class" => "input-block-level",
							"placeholder" => __("New password"),
							"required" => true,
							"autocomplete" => "off"
					)
				),
				'confirm_password' => new sfWidgetFormInputPassword(
					array(),
					array(
							"class" => "input-block-level",
							"placeholder" => __("Confirm password"),
							"required" => true,
							"autocomplete" => "off"
					)
				)
			)
		);

		$this->widgetSchema->setNameFormat('data[%s]');

		$this->setValidators(
			array(
				'h' => new sfValidatorString(
					array(
						'required' => false
					),
					array()
				),
				'v' => new sfValidatorString(
					array(
						'required' => false
					),
					array()
				),
				/* 
				'password' => new sfValidatorString(
					array(
						'required' => true
					),
					array(
						'required' => __("New password is required.")
					)
				),
				*/
				'password' => new sfValidatorCallback(
					array(
						'required' => true,
						'callback' => array($this, 'checkPasswordStrength')
					)
				),
				'confirm_password' => new sfValidatorString(
					array(
						'required' => true
					),
					array(
						'required' => __("Please verify your new password.")
					)
				)
			)
		);

		$this->validatorSchema->setPostValidator(
			new sfValidatorAnd(
				array(
					new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'confirm_password',
						array(),
						array(
							'invalid' => __("Passwords do not match, please check and try again.")
						)
					)
				)
			)
		);
	}

	/*________________________________________________________________________________________________________________*/
	public function checkPasswordStrength($validator, $password) {
		/* 
			At least 6 characters
			At least 1 number
			At least 1 lowercase letter
			At least 1 uppercase letter
			At least 1 special character. Special charaters include !@#$&#%^&+=.<>?
		*/

		if (!preg_match("@^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!\@#$%\^&+=\.<>\?]).*$@", $password)) {
			throw new sfValidatorError($validator, __("Password must be 8 characters long, contain at least 1 number, contain 1 uppercase letter, contain 1 lowercase letter and contain a special character"));
		}

		return $password;
	}
}