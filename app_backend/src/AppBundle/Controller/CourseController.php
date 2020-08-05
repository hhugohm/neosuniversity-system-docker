<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\TcCourse;
use AppBundle\Entity\TrClass;
use AppBundle\Entity\TrClassFiles;
use AppBundle\Entity\TrCourseSection;
use AppBundle\Entity\TwClass;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Services\CourseService;
use AppBundle\Services\SecurityService;
use AppBundle\Exceptions\SecurityException;
use AppBundle\Exceptions\CourseException;

//use Firebase\JWT\JWT;

/**
 * CoursController este controllador tiene la funcionalidad de servicios rest
 * para la capa web
 *
 * @author Mario Hidalgo
 * aka neossoftware
 */
class CourseController extends FOSRestController
{

    private $entityManager;

    /**
     * @Rest\Get("/api/getcourse")
     */
    public function getAll()
    {

        $this->get('logger')->info("this is a test message");

        $this->entityManager = $this->getDoctrine()->getManager();

        $query = $this->entityManager->createQuery('select c from AppBundle\Entity\TcCourse c');
        $result = $query->getResult();
        return $result;
        // $courseService = $this->get('courseService');


        //return $courseService->getAll();
    }

    /**
     * obtiene un curso por ID
     *
     * @Rest\Post("/api/getcourse")
     */

    public function getById(Request $request)
    {
        $courseService = $this->get('courseService');

        $securityService = $this->get('securityService');
        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        $courseId = $request->get('courseId');

        return $courseService->getById($courseId);
    }

    /**
     * get premier courses
     *
     * @Rest\Post("/api/getPremierCourses")
     */

    public function getPremierCourses(Request $request)
    {
        $courseService = $this->get('courseService');

        $this->validateSecurity($request);

        return $courseService->getPremierCourses();

    }


    /**
     * Valida si una persona ya esta inscrita a un curso
     *
     * @Rest\Post("/api/course/validateSubscription")
     *
     * @param [Request] $request
     * @return $response
     */
    public function validateSubscription(Request $request)
    {

        $courseService = $this->get('courseService');
        $securityService = $this->get('securityService');

        $email = $request->get('email');
        $courseId = $request->get('courseId');

        try {

            $securityService->validateToken($request);
            $courseService->validateInscription($courseId, $email);

        } catch (CourseException $e) {
            return $response = array(
                "code" => 1,
                "message" => "El usuario ya tiene el curso asignado"
            );
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        return $response = array(
            "code" => 0,
            "message" => "El usuario no tiene el curso asignado"
        );

    }

    /**
     * @Rest\Post("/api/course/subscription")
     */
    public function subscription(Request $request)
    {

        $logger = $this->get('logger');

        $securityService = $this->get('securityService');
        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }
        //get info
        $email = $request->get('email');
        $courseId = $request->get('courseId');

        $logger->debug('*****************SUBSCRIPTION ***********************');

        $logger->debug('email: ' . $email . ' courseId: ' . $courseId);

        $courseService = $this->get('courseService');

        return $courseService->doInscription($courseId, $email);


    }


    /**
     *
     * @Rest\Post("/api/course/subscriptionPremier")
     */
    public function subscriptionPremier(Request $request ){

        $logger = $this->get('logger');

        $this->validateSecurity($request);

        //get info
        $email = $request->get('email');
        $courseId = $request->get('courseId');
        $payIsComplete = $request->get('payIsComplete');
        $paypalOrderId = $request->get('paypalOrderId');
        $paypalPaymentId = $request->get('paypalPaymentId');

        $logger->debug('*****************SUBSCRIPTION  PREMIER***********************');

        $logger->debug('email: ' . $email . ' courseId: ' . $courseId);

        $courseService = $this->get('courseService');

        return $courseService->doInscription($courseId, $email, FALSE,
            $payIsComplete, $paypalOrderId, $paypalPaymentId);

    }

    /**
     * @Rest\Post("/api/course/allsections")
     */
    public function allSections(Request $request)
    {

        $logger = $this->get('logger');
        $securityService = $this->get('securityService');
        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        $courseService = $this->get('courseService');
        $courseId = $request->get('courseId');

        $logger->debug('obteniendo todas las secciones de los cursos');

        return $courseService->getCourseSections($courseId);
    }

    /**
     * @Rest\Post("/api/course/alltwsections")
     */
    public function allTwSections(Request $request)
    {

        $logger = $this->get('logger');
        $securityService = $this->get('securityService');

        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        $courseService = $this->get('courseService');
        $email = $request->get('email');
        $courseId = $request->get('courseId');

        $logger->debug('Obteniendo las secciones de tw section');

        return $courseService->getTwCourseSections($courseId, $email);

    }

    /**
     * @param Request $request
     * @Rest\Post("/api/course/getTrClass")
     */
    public function getTrClass(Request $request) {
        $this->validateSecurity($request);
        $courseService = $this->get('courseService');

        $classId = $request->get('classId');
        $sectionId = $request->get('sectionId');

        $tw_class = new TwClass();
        $tw_class->setClassId($classId);
        $tw_class->setSectionId($sectionId);

        return $courseService->getTrClass($tw_class);

    }

    /**
     * @Rest\Post("/api/course/getTwClass")
     */
    public function getTwClass(Request $request)
    {

        $logger = $this->get('logger');
        $securityService = $this->get('securityService');

        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        $courseService = $this->get('courseService');

        $classId = $request->get('classId');
        $controlPanelId = $request->get('controlPanelId');
        $sectionId = $request->get('sectionId');

        return $courseService->getTwClass($classId, $controlPanelId, $sectionId);
    }

    /**
     * @Rest\Post("/api/course/saveTwClassComplete")
     */
    public function saveTwClassComplete(Request $request)
    {

        $logger = $this->get('logger');
        $securityService = $this->get('securityService');

        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        $courseService = $this->get('courseService');

        $classId = $request->get('classId');
        $controlPanelId = $request->get('controlPanelId');
        $sectionId = $request->get('sectionId');

        $courseService->saveTwClassComplete($classId, $controlPanelId, $sectionId);

        return $response = array(
            "code" => 0,
            "message" => "actualizacion exitosa"
        );

    }

    /**
     * obtiene cursos por User Id
     * @Rest\Post("/api/course/getCoursesByUser")
     */
    public function getCoursesByUser(Request $request)
    {

        $securityService = $this->get('securityService');

        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        $courseService = $this->get('courseService');

        $email = $request->get('email');

        $courses = $courseService->getCoursesByUser($email);

        return $courses;
    }


    /**
     * Obtiene el temario de un curso en especifico.
     *
     * @Rest\Post("/api/course/getTrCourseSectionsPremier")
     */
    public function getTrCourseSectionsPremier(Request $request) {


        $this->validateSecurity($request);

        $courseService = $this->get('courseService');

        $courseId = $request->get('courseId');

        $sections = $courseService->getTrCourseSectionsPremier($courseId);

        return $sections;

    }


    /**
     * Obtiene el temario de un curso en especifico.
     *
     * @Rest\Post("/api/course/getTrCourseSections")
     */
    public function getTrCourseSections(Request $request) {

        $securityService = $this->get('securityService');

        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }

        $courseService = $this->get('courseService');

        $courseId = $request->get('courseId');

        $courses = $courseService->getTrCourseSections($courseId);

        return $courses;


    }


    /**
     * Agrega un nuevo curso a la BD
     *
     * @Rest\Post("/api/course/addNewCourse")
     */
    public function addNewCourse(Request $request)
    {

        $this->validateSecurity($request);

        $courseService = $this->get('courseService');
        $tccourse = $this->getTcCourseReq($request);

        $logger = $this->get('logger');

        $result = $courseService->addNewCourse($tccourse);

        $code = $result == true ? 1 : 0;

        return $response = array(
            "code" => 0,
            "message" => "El curso se dio de alta exitosamente"
        );

    }

    /**
     * Actualiza los datos de un curso
     *
     * @param Request $request
     * @return array
     *
     * @Rest\Post("/api/course/updateCourse")
     */
    public function updateCourse(Request $request) {
        $this->validateSecurity($request);
        $tccourse = $this->getTcCourseReq($request);
        $tccourse->setId($request->get("id"));

        $courseService = $this->get('courseService');
        $logger = $this->get('logger');

        return $courseService->updateCourse($tccourse);

    }

    /**
     * Guarda una nueva unidad
     *
     * @param Request $request
     * @return array
     *
     * @Rest\Post("/api/course/saveNewSection")
     */
    public function saveNewSection(Request $request) {
        $logger = $this->get('logger');

        $this->validateSecurity($request);
        $sectionName = $request->get('sectionName');
        $courseId = $request->get('courseId');

        $logger->debug('sectionname: ' . $sectionName);
        $logger->debug('courseId: '. $courseId );

        $section = new TrCourseSection();
        $section->setCourseId($courseId);
        $section->setDescription($sectionName);

        $courseService = $this->get('courseService');

        return $courseService->saveNewSection($section);

    }

    /**
     * Guarda una nueva clase
     *
     * @param Request $request
     * @return array
     *
     * @Rest\Post("/api/course/saveNewClass")
     */
    public function saveNewClass(Request $request) {

        $logger = $this->get('logger');

        $this->validateSecurity($request);

        $clase = new TrClass();
        $clase->setSectionId($request->get('sectionId'));
        $clase->setVideourl($request->get('videoURL'));
        $clase->setClassdescription($request->get('classDescription'));

        $logger->debug('URL:' . $clase->getVideourl() );

        $courseService = $this->get('courseService');

        return $courseService->addNewTrClass($clase);

    }



    /**
     * obtiene los alumnos inscritos a un curso determinado
     *
     * @param Request $request
     * @return array
     *
     * @Rest\Post("/api/course/getUsersByCourse")
     */
    public function getUsersByCourse(Request $request) {

        $this->validateSecurity($request);

        $courseId = $request->get('courseId');

        $courseService = $this->get('courseService');

        return $courseService->getUsersByCourse($courseId);

    }

    /**
     * obtiene los usuarios que inician con ..
     *
     * @param Request $request
     * @return array
     *
     * @Rest\Post("/api/course/getUserslikemail")
     */
    public function getUsersLikeMail(Request $request) {

        $this->validateSecurity($request);

        $email = $request->get('email');

        $courseService = $this->get('courseService');

        return $courseService->getUsersByLikeMail($email);

    }


    /**
     * Guarda una nueva clase
     *
     * @param Request $request
     * @return array
     *
     * @Rest\Post("/api/course/updateSection")
     */
    public function updateSection(Request $request) {

        $logger = $this->get('logger');

        $this->validateSecurity($request);

        $section = new TrCourseSection();

        $id = $request->get('sectionId');
        $section->setDescription($request->get('description'));

        $courseService = $this->get('courseService');

        return $courseService->updateSection($section, $id);

    }


    /**
     * Guarda una nueva clase
     *
     * @param Request $request
     * @return array
     *
     * @Rest\Post("/api/course/updateClase")
     */
    public function updateClase(Request $request)
    {

        $logger = $this->get('logger');

        $this->validateSecurity($request);

        $clase = new TrClass();

        $clase->setClassdescription($request->get('classDescription'));
        $clase->setSectionId($request->get('sectionId'));
        $clase->setClassId($request->get('classId'));
        $clase->setVideourl($request->get('videoURL'));

        $courseService = $this->get('courseService');

        return $courseService->updateClase($clase);


    }

    /**
     * Obtiene los archivos de una clase en particular
     *
     * @Rest\Post("/api/course/getFilesByClass")
     **/
    public function getFilesByClass(Request $request) {


        $this->validateSecurity($request);

        $clase = new TwClass();
        $clase->setSectionId($request->get('sectionId'));
        $clase->setClassId($request->get('classId'));

        $courseService = $this->get('courseService');

        return $courseService->getFilesByClase($clase);
    }

    /**
     * Rest que agrega un nuevo archivo en una clase
     *
     *
     * @Rest\Post("/api/course/addFileToClass")
     **/
    public function addFileToClass(Request $request) {


        $this->validateSecurity($request);

        $file = new TrClassFiles();
        $file->setSectionId($request->get('sectionId'));
        $file->setClassId($request->get('classId'));
        $file->setFileName($request->get('fileName'));
        $file->setFilePath($request->get('filePath'));


        $courseService = $this->get('courseService');

        return $courseService->addFileToClass($file);

    }

    /**
     * Rest que modifica un archivo asociado a una clase
     *
     * @Rest\Post("/api/course/updateFile")
     **/
    public function updateFile(Request $request) {


        $this->validateSecurity($request);

        $file = new TrClassFiles();
        $file->setId($request->get('id'));

        $file->setFileName($request->get('fileName'));
        $file->setFilePath($request->get('filePath'));


        $courseService = $this->get('courseService');

        return $courseService->updateFile($file);

    }


        /**
     * Valida la seguridad de la peticion
     *
     * @param Request $request
     * @return Response
     */
    private  function validateSecurity(Request $request) {

        $securityService = $this->get('securityService');

        try {
            $securityService->validateToken($request);
        } catch (SecurityException $e) {
            return new Response('{"error": "No autorizado"}', Response::HTTP_FORBIDDEN);
        }


    }


    /**
     * Obtiene el Tccourse de la peticion http
     * @param Request $request
     * @return TcCourse
     */
    private function getTcCourseReq(Request $request) {

        $courseName = $request->get('courseName');
        $author = $request->get('author');
        $isFree = $request->get('isFree');
        $isOnline = $request->get('isOnline');
        $cost = $request->get('cost');
        $imgThumb = $request->get('imgThumb');
        $img = $request->get('img');
        $shortDesc = $request->get('shortDesc');
        $description = $request->get('description');
        $urlcourseonline = $request->get('urlcourseonline');

        $tccourse = new TcCourse();
        $tccourse->setAuthorId($author);
        $tccourse->setCost($cost);
        $tccourse->setCoursedesc($description);
        $tccourse->setCoursename($courseName);
        $tccourse->setImgcourse($img);
        $tccourse->setImgthumb($imgThumb);
        $tccourse->setShortdesc($shortDesc);
        $tccourse->setIsfree($isFree);
        $tccourse->setIsOnline($isOnline);
        $tccourse->setUrlCourseOnline($urlcourseonline);

        return $tccourse;

    }




    }