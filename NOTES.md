## **USERS**
- name
- email
- password
- email_verified_at
- timestamps
- softdeletes

## INCOMES
- description
- recurrent_income_id
- value
- period_date
- timestamps

## EXPENSES
- description
- recurrent_expense_id
- expenses_category_id
- value
- period_date
- due_day
- timestamps

## RECURRENT_INCOMES
- description
- default_value
- status
- timestamps

## RECURRENT_EXPENSES
- description
- expenses_category_id
- default_value
- limit_value
- due_day
- status
- timestamps

## EXPENSES_CATEGORIES
- name
- timestamps

## NOTIFICATIONS
- user_id
- content
- read
- timestamps

## CHECK HOW TO IMPLEMENT UUID IN THE MODELS AND TABLES
## IMPLMENT ALL FEAT TESTS
