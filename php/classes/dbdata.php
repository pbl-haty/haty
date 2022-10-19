<?php                     
  class  DbData {              // DbDataクラスの宣言     
                      
      protected  $pdo;         // PDOオブジェクト用のプロパティ（メンバ変数）の宣言     
                      
      public function __construct( ) {   // コンストラクタ     
          // PDOオブジェクトを生成する                     
          $dsn = 'mysql:host=localhost;dbname=haty;charset=utf8';                     
          $user = 'haty';                    
          $password = 'haty';       

// デプロイ          
//          $dsn = 'mysql:host=database-1.c0ldwtkfy8hi.ap-northeast-1.rds.amazonaws.com;dbname=haty;charset=UTF8';
//          $user = 'admin';
//          $password = 'haty_D04';

          try{                      
              $this->pdo = new PDO($dsn, $user, $password);                     
          } catch(Exception  $e){                     
              echo 'Error:' . $e->getMessage( );                      
              die( );                     
          }                     
      }                     
                      
      protected function query ( $sql,  $array_params ) {  // SELECT文実行用のメソッド
          $stmt = $this->pdo->prepare( $sql );                      
          $stmt->execute( $array_params );                 
          return  $stmt;          // PDOステートメントオブジェクトを返すのでfetch( )、fetchAll( )で結果セットを取得           
      }
                      
      protected function exec ( $sql,  $array_params ) {  // INSERT、UPDATE、DELETE文実行用のメソッド
          $stmt = $this->pdo->prepare( $sql );                      
          return  $stmt->execute( $array_params );        // 成功：true、失敗：false
      }                     
  }                     
