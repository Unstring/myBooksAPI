<?php

class BookService extends Requests
{
  public function index()
  {
    $method = $this->getMethod();

    $book = new Book();

    $jwt = new JWT();
    $authorization = new Authorization();

    $result = [];

    if ($method == 'GET') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          $result = [
            'quantity' => count($book->list($user->id)),
            'books' => $book->list($user->id)
          ];
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function create()
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();

    $book = new Book();

    $jwt = new JWT();
    $authorization = new Authorization();

    $result = [];

    if ($method == 'POST') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          if (!empty($body['title']) && !empty($body['year'])) {

            $create_book = $book->create([$body['title'], $body['year'], $user->id]);

            if ($create_book) {
              http_response_code(200);
              $result['message'] = "Book created";
            } else {
              http_response_code(406);
              $result['error'] = "Sorry, something went wrog, verify the fields";
            }
          } else {
            http_response_code(406);
            $result['error'] = "Title or Year field is empty";
          }
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function listById($id)
  {
    $method = $this->getMethod();

    $book = new Book();

    $jwt = new JWT();
    $authorization = new Authorization();

    $result = [];

    if ($method == 'GET') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          $book_id = $id[0];
          $user_id = $user->id;
          $book_exists = $book->listById([$book_id, $user_id]);

          if ($book_exists) {
            $result['book'] = $book_exists;
          } else {
            http_response_code(404);
            $result['error'] = "Book not found";
          }
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function update($id)
  {
    $method = $this->getMethod();
    $body = $this->parseBodyInput();

    $book = new Book();

    $jwt = new JWT();
    $authorization = new Authorization();

    $result = [];

    if ($method == 'PUT') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          if (!empty($body['title']) && !empty($body['year'])) {

            $book_id = $id[0];
            $user_id = $user->id;

            $updated = $book->update([$body['title'], $body['year'], $book_id, $user_id]);

            if ($updated) {
              $result['message'] = "Book updated";
            } else {
              http_response_code(406);
              $result = [
                'error_01' => "Verify title or year, try different values",
                'error_02' => "Sorry, something went wrog, verify the ID"
              ];
            }
          } else {
            http_response_code(406);
            $result['error'] = "Title or Year field is empty";
          }
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function listAll()
  {
    $method = $this->getMethod();

    $book = new Book();
    $userG = new User();

    $jwt = new JWT();
    $authorization = new Authorization();

    $result = [];

    if ($method == 'GET') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          
          if ($userG->isAdmin($user->id)) {
            $result = [
              'quantity' => count($book->listAll()),
              'books' => $book->listAll()
            ];
          } else {
            http_response_code(401);
            $result['error'] = "Unauthorized, You are not an admin";
          }
          
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }


  public function allData()
  {
    $method = $this->getMethod();

    $book = new Book();
    $userG = new User();

    $jwt = new JWT();
    $authorization = new Authorization();

    $result = [];

    if ($method == 'GET') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          
          if ($userG->isAdmin($user->id)) {
            $result = [
              'count' => count($userG->allData()),
              'data' => $userG->allData()
            ];
          } else {
            http_response_code(401);
            $result['error'] = "Unauthorized, You are not an admin";
          }
          
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }

  public function remove($id)
  {
    $method = $this->getMethod();

    $book = new Book();

    $jwt = new JWT();
    $authorization = new Authorization();

    $result = [];

    if ($method == 'DELETE') {
      $token = $authorization->getAuthorization();

      if ($token) {
        $user = $jwt->validateJWT($token);

        if ($user) {

          $book_id = $id[0];
          $user_id = $user->id;

          $delete_book = $book->remove([$book_id, $user_id]);

          if ($delete_book) {
            $result['message'] = "Book deleted";
          } else {
            http_response_code(406);
            $result['error'] = "Sorry, something went wrog, book not exists";
          }
        } else {
          http_response_code(401);
          $result['error'] = "Unauthorized, please, verify your token";
        }
      } else {
        http_response_code(401);
        $result['error'] = "Unauthorized, please, verify your token";
      }
    } else {
      http_response_code(405);
      $result['error'] = "HTTP Method not allowed";
    }

    echo json_encode($result);
  }
}
