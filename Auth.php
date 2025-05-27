<?php
namespace Services;

/**
 * Classe que gerencia a autenticação de usuários
 */
class Auth {
    /**
     * Conexão com o banco de dados
     * @var \PDO
     */
    private \PDO $db;

    /**
     * Construtor da classe Auth
     */
    public function __construct() {
        $this->db = getConnection();
    }

    /**
     * Realiza o login do usuário
     * 
     * @param string $username Nome de usuário
     * @param string $password Senha do usuário
     * @return bool Retorna true se o login for bem-sucedido, false caso contrário
     */
    public function login(string $username, string $password): bool {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['auth'] = [
                'logado' => true,
                'username' => $username,
                'perfil' => $usuario['perfil']
            ];
            return true;
        }
        return false;
    }

    /**
     * Encerra a sessão do usuário 
     */
    public function logout(): void {
        session_destroy();
    }

    /**
     * Verifica se o usuário está autenticado
     * 
     * @return bool Retorna true se o usuário estiver autenticado, false caso contrário
     */
    public function verificarLogin(): bool {
        return isset($_SESSION['auth']) && $_SESSION['auth']['logado'] === true;
    }

    /**
     * Verifica se o usuário tem determinado perfil
     * 
     * @param string $perfil Perfil a ser verificado 
     * @return bool Verdadeiro se o usuário tem o perfil
     */
    public static function isPerfil(string $perfil): bool {
        return isset($_SESSION['auth']) && $_SESSION['auth']['perfil'] === $perfil;
    }


    /**
     * verifica se o usuario tem perfil de administrador
     * 
     * @return bool verdadiero se for administrador
     */

     public static function isAdmin(): bool {
        return self::isPerfil('admin');
     }

     /**
      * obtem as in formaçoes do usuario logado
      * @return array|null dados do usuario ou null se nao estiver logado
      */

      public static function getUsuario(): ?array {
        return $_SESSION['auth'] ?? null;
      }

      /**
       * verifica se o usuario tem eprmissao para uma açao espeficica baseado em uma matriz de permissoes por perfil
       * 
       * @param string $acao A açao a ser veficicada
       * @return bool verdadeiro se o usuario tem permissao
       *
       */
      public static function temPermissao(string $acao): bool {
        $usuario = self::getUsuario();
        if(!$usuario) {
            return false;
        }

        // matriz de permissoes por perfil

        $permissoes = [
            'admin' => [
                'visualizar' => true,
                'adicionar' => true,
                'alugar' => true,
                'devolver' => true,
                'deletar' => true,
                'calcular' => true,
            ],
            'usuario' => [
                'visualizar' => true,
                'adicionar' => false,
                'alugar' => false,
                'devolver' => false,
                'deletar' => false,
                'calcular' => true,

            ]

            // pode se adicionar faculmente novos perfis, como:
            // 'gerente' => [
            //     'visualizar' => true,
            //     'adicionar' => true,
            //     'alugar' => false,
            //     'devolver' => false,
            //     'deletar' => false,
            //     'calcular' => true,
            // ]
            ];

            // verifica se o perfil e a açao existem na amtriz
            if(!isset($permissoes[$usuario['perfil']]) || !isset($permissoes[$usuario['perfil']][$acao])) {
                return false;
            }

            return $permissoes[$usuario['perfil']][$acao];


      }



}
        