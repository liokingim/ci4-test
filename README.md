# CodeIgniter 4 Application Starter

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](https://codeigniter.com).

This repository holds a composer-installable app starter.
It has been built from the
[development repository](https://github.com/codeigniter4/CodeIgniter4).

More information about the plans for version 4 can be found in [CodeIgniter 4](https://forum.codeigniter.com/forumdisplay.php?fid=28) on the forums.

The user guide corresponding to the latest version of the framework can be found
[here](https://codeigniter4.github.io/userguide/).

## Installation & updates

`composer create-project codeigniter4/appstarter` then `composer update` whenever
there is a new release of the framework.

When updating, check the release notes to see if there are any changes you might need to apply
to your `app` folder. The affected files can be copied or merged from
`vendor/codeigniter4/framework/app`.

## Setup

Copy `env` to `.env` and tailor for your app, specifically the baseURL
and any database settings.

## Important Change with index.php

`index.php` is no longer in the root of the project! It has been moved inside the *public* folder,
for better security and separation of components.

This means that you should configure your web server to "point" to your project's *public* folder, and
not to the project root. A better practice would be to configure a virtual host to point there. A poor practice would be to point your web server to the project root and expect to enter *public/...*, as the rest of your logic and the
framework are exposed.

**Please** read the user guide for a better explanation of how CI4 works!

## Repository Management

We use GitHub issues, in our main repository, to track **BUGS** and to track approved **DEVELOPMENT** work packages.
We use our [forum](http://forum.codeigniter.com) to provide SUPPORT and to discuss
FEATURE REQUESTS.

This repository is a "distribution" one, built by our release preparation script.
Problems with it can be raised on our forum, or as issues in the main repository.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

## trigram 기반 인덱스 일본어 텍스트
CREATE EXTENSION IF NOT EXISTS pg_trgm;

CREATE TABLE japanese_documents (
    id SERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL
);

## Gin 인덱스
CREATE INDEX japanese_documents_content_trgm_gin ON japanese_documents USING gin(content gin_trgm_ops);

## GiST 인덱스
CREATE INDEX japanese_documents_content_trgm_gist ON japanese_documents USING gist(content gist_trgm_ops);

SELECT * FROM japanese_documents WHERE content LIKE '%現代%';

## CockroachDB
CREATE TABLE ci_sessions (
    id VARCHAR PRIMARY KEY,
    data BYTEA,
    last_activity TIMESTAMP
);

DELETE FROM ci_sessions WHERE now() - INTERVAL '1 hour' > last_activity;

## Task Runner
php spark tasks:run

## Test

1. Controller Test Specification

Test Case 1: Get Request

Objective: 확인할 내용: GET 요청이 올바르게 처리되는지.
Procedure: 테스트 프로세스: GET 요청을 보냅니다.
Expected Result: 예상 결과: HTTP 상태 코드 200을 반환합니다.

Test Case 2: Post Request

Objective: 확인할 내용: POST 요청이 올바르게 처리되는지.
Procedure: 테스트 프로세스: POST 요청을 보냅니다.
Expected Result: 예상 결과: HTTP 상태 코드 200을 반환합니다.

Test Case 3: Validation

Objective: 확인할 내용: 올바른 데이터가 들어왔을 때 및 잘못된 데이터가 들어왔을 때 각각의 경우를 확인합니다.
Procedure: 테스트 프로세스: 올바른 데이터와 잘못된 데이터를 각각 보냅니다.
Expected Result: 예상 결과: 올바른 데이터는 HTTP 상태 코드 200을 반환하고, 잘못된 데이터는 HTTP 상태 코드 400 또는 422를 반환합니다.

Test Case 4: Response Check

Objective: 확인할 내용: 응답 내용이 올바른지.
Procedure: 테스트 프로세스: 요청을 보내고 응답을 확인합니다.
Expected Result: 예상 결과: 예상하는 응답 데이터가 반환됩니다.

Test Case 5: Database Change Check

Objective: 확인할 내용: 데이터베이스 값이 예상대로 변경되는지.
Procedure: 테스트 프로세스: 요청을 보내고 데이터베이스를 확인합니다.
Expected Result: 예상 결과: 데이터베이스 값이 예상한 변경 내용대로 반영됩니다.

2. Services Test Specification

Test Case 1: Model Value Check

Objective: 확인할 내용: 모델 값이 올바르게 처리되는지.
Procedure: 테스트 프로세스: 서비스 메소드를 호출하고 모델의 상태를 확인합니다.
Expected Result: 예상 결과: 모델의 상태가 예상대로 변경됩니다.

Test Case 2: Return Value Check

Objective: 확인할 내용: 서비스 메소드의 반환 값이 올바른지.
Procedure: 테스트 프로세스: 서비스 메소드를 호출하고 반환 값을 확인합니다.
Expected Result: 예상 결과: 반환 값이 예상한 값과 일치합니다.

## Test 테이블

Controller
Test Case ID	Description	                            Input	                    Expected Output	                                              Method	Path
C1	            BankController의 get 요청 테스트	    없음	                        성공적인 HTTP 응답 (200 OK)	                                GET	/bank
C2	            BankController의 post 요청 테스트	    bank_code, branch_number	    성공적인 HTTP 응답 (200 OK)	                                POST	/bank
C3	            BankController의 validation 실패 테스트	bank_code 또는 branch_number    누락 또는 형식 불일치	HTTP 응답 오류 (400 Bad Request)	    POST	/bank
C4	            BankController의 response 값 테스트	    bank_code, branch_number	    기대하는 응답 값	                                        GET or POST	/bank
C5	            BankController의 DB 값 변경 테스트	    bank_code, branch_number	    DB 값의 변경 확인	                                        GET or POST	/bank

Services
Test Case ID	Description	                            Input	            Expected Output
S1	            BankService의 deposit 메소드 테스트	    bank_id, amount	        DB의 변화, boolean 값 리턴
S2	            BankService의 withdraw 메소드 테스트	bank_id, amount	        DB의 변화, boolean 값 리턴
S3	            BankService의 validation 실패 테스트	잘못된 bank_id, amount	예외 발생
S4	            BankService의 모델 호출 확인	        bank_id, amount	        모델 메소드 호출 확인
