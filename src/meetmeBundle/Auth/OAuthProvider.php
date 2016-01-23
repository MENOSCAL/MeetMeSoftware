<?php
namespace meetmeBundle\Auth;
 
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use meetmeBundle\Entity\User;
 
class OAuthProvider extends OAuthUserProvider
{
    protected $session, $doctrine, $admins;
 
    public function __construct($session, $doctrine, $service_container)
    {
        $this->session = $session;
        $this->doctrine = $doctrine;
        $this->container = $service_container;
    }
    
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();
        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();
        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';
        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }
        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    
 
    public function loadUserByUsername($username)
    {
 
        $qb = $this->doctrine->getManager()->createQueryBuilder();
        $qb->select('u')
            ->from('meetmeBundle\Entity\User', 'u')
            ->where('u.googleId = :gid')
            ->setParameter('gid', $username)
            ->setMaxResults(1);
        $result = $qb->getQuery()->getResult();
 
        if (count($result)) {
            return $result[0];
        } else {
            return new User();
        }
    }
 
     public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $google_id = $response->getUsername();
        $email = $response->getEmail();
        
       //Check if this Google user already exists in our app DB
        $qb = $this->doctrine->getManager()->createQueryBuilder();
        $qb->select('u')
            ->from('meetmeBundle\Entity\User', 'u')
            ->where('u.googleId = :gid')
            ->setParameter('gid', $google_id)
            ->setMaxResults(1);
        $result = $qb->getQuery()->getResult();
        //when the user is registrating
         if (!count($result)) {
            
//            $service = $response->getResourceOwner()->getName();
////            $setter = 'set'.ucfirst($service);
////            $setter_id = $setter.'Id';
////            $setter_token = $setter.'AccessToken';
            
            // create new user here
            $user = new User();
            $user->setGoogleId($google_id);
            $user->setGoogleAccessToken($response->getAccessToken());
            
            //I have set all requested data with the user's username
            //modify here with relevant data
            $user->setUsername($google_id);
            $user->setEmail($email);
            
            //Set some wild random pass since its irrelevant, this is Google login
            $factory = $this->container->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword(md5(uniqid()), $user->getSalt());
            $user->setPassword($password);
            
            $user->setStatus(1);
            
            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
            
            return $user;
        }else{
            $user = $result[0]; /* return User */
        }
       //set id
        $this->session->set('id', $user->getId());
 
        return $this->loadUserByUsername($response->getUsername());
    }
    
    
    public function supportsClass($class)
    {
        return $class === 'meetmeBundle\\Entity\\User';
    }
}