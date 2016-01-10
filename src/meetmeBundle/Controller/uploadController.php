<?php

namespace meetmeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use meetmeBundle\Entity\Image;
use Symfony\Component\HttpFoundation\Request;

class uploadController extends Controller{
    
    public function uploadAction(Request $request)
    { 
        
        $sesion = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('meetmeBundle:User'); 
        $login = $sesion->get('login');
        $username = $login->getUsername();
        $password = $login->getPassword();
        $user = $repository->findOneBy(array('username'=>$username,'password'=>$password));
        
        //try {
            //Archive data.
            $fileName = $_FILES['userfile']['name']; 
            $fileType = $_FILES['userfile']['type']; 
            $fileSize = $_FILES['userfile']['size']; 
            $file=$_FILES['userfile']['tmp_name'];
            $fileError = $_FILES['userfile']['error'];
            // Undefined | Multiple Files | $_FILES Corruption Attack
            // If this request falls under any of them, treat it invalid.
            if (
                !isset($fileError) ||
                is_array($fileError)
               ) {
                 throw new RuntimeException('Invalid parameters.');
                 }
            // Check $_FILES['upfile']['error'] value.
            switch ($fileError) {
            case UPLOAD_ERR_OK:
                 break;
            case UPLOAD_ERR_NO_FILE:
                 throw new RuntimeException('No file sent.');
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                 throw new RuntimeException('Exceeded filesize limit.');
            default:
                 throw new RuntimeException('Unknown errors.');
            }
             // You should also check filesize here. 
            if ($fileSize > 100000) {
                 throw new RuntimeException('Exceeded filesize limit.');
            }
            $allowed =  array('gif','png' ,'jpg');
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            if(!in_array($ext,$allowed) ) {
                //echo 'error';
                //echo "The extent or size of the files is not correct. <br><br><table><tr><td><li>.jpg, .png or .gif files allowed</li></td></tr></table>"; 
            }   
            else{ 
                if (move_uploaded_file($file, __DIR__.'/../../../web/bundles/meetme/images/'.$fileName)){ 
                    //echo "Upload successful.";
                    $em = $this->getDoctrine()->getManager();
                    $qb = $em->createQueryBuilder();
                    $q = $qb->update('meetmeBundle\Entity\Image', 'i')
                    ->set('i.isActive', '?1')
                    ->where('i.iduser = ?2')
                    ->setParameter(1, 0)
                    ->setParameter(2, $user->getId())
                    ->getQuery();
                    $p = $q->execute();
       
                    $image = new Image();
                    $image->setPath($fileName);
                    $image->setIduser($user);
                    $image->setIsActive(1);
                    $em->persist($image);
                    $em->flush();
                    //return $this->redirectToRoute('meetme_upload_success');
                    return $this->redirectToRoute('meetme_login');
                }else{ 
                    //echo "Upload fail."; 
               } 
            } 
//        }catch (RuntimeException $e) {
//         echo $e->getMessage();
//         }
    }
    
    public function uploadsuccessAction()
    {
        return $this->render('meetmeBundle:twig_html:responseuploadsuccessful.html.twig');
    }
}
