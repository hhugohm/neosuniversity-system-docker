<?php

/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Services;

use AppBundle\Entity\TrClass;
use AppBundle\Entity\TrClassFiles;
use AppBundle\Entity\TrCourseSection;
use AppBundle\Model\UserView;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\TcCourse;
use AppBundle\Entity\TwControlPanel;
use AppBundle\Entity\TwSection;
use AppBundle\Entity\TwClass;
use AppBundle\Exceptions\CourseException;
use Psr\Log\LoggerInterface;

/*
 *
 *Course Service Class
 * @author Mario Hidalgo <neossoftware@gmail.com>
 */

class CourseService
{
    /***
     *entityManager es el objeto para poder tener acceso a la BD por medio de ORM
     */
    private $entityManager = null;
    private $logger = null;
    private $userService = null;


    public function __construct(EntityManager $entityManager, LoggerInterface $logger, UserService $userService)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->userService = $userService;
    }

    /***
     *Get All courses from DB
     */
    public function getAll()
    {

        $query = $this->entityManager->createQuery('select c from AppBundle\Entity\TcCourse c');
        $result = $query->getResult();
        return $result;

        //  $courses = $this->entityManager->getRepository('AppBundle:TcCourse')->findAll();
        //  return $courses;
    }


    public function getPremierCourses() {

        $repository = $this->entityManager->getRepository('AppBundle:TcCourse');

        $sections = $repository->findAll();
        /*
        findBy(
            ['isfree' => 0]
        ); */

        return $sections;

    }

    /**
     *get acourse by ID
     */
    public function getById($id)
    {

        $repository = $this->entityManager->getRepository('AppBundle:TcCourse');
        return $repository->find($id);

    }

    /**
     * valida si un curso ya fue asignado a una persona
     *
     * @param [Integer] $courseId
     * @param [String] $username
     * @return void
     */
    public function validateInscription($courseId, $username)
    {

        $course = $this->getTwControlPanelBy($courseId, $username);

        //el curso existe en la BD debe mandar el aviso al front end de que ya esta inscrito el alumno
        if ($course !== NULL) {
            throw new CourseException('El alumno ya esta inscrito al curso');
        }
    }

    /**
     * Busca en la tabla tw_control_panel
     *
     * @param [type] $courseId
     * @param [type] $username
     * @return TwControlPanel
     */
    public function getTwControlPanelBy($courseId, $username)
    {

        $repository = $this->entityManager->getRepository('AppBundle:TwControlPanel');

        $course = $repository->findOneBy([
            'courseId' => $courseId,
            'emailId' => $username
        ]);

        return $course;
    }

    /**
     * valida si el alumno esta inscritp en el curso
     */
    public function doInscription($courseId, $username, $isFree = TRUE ,
                                  $payIsComplete=0, $paypalOrderId = NULL, $paypalPaymentId =NULL)
    {

        try {

            $this->validateInscription($courseId, $username);

        } catch (CourseException $e) {
            return $response = array(
                "code" => 1,
                "message" => "El usuario ya tien el curso asignado"
            );
        }

        $dateObject = new \DateTime();

        $twcontrolPanel = new TwControlPanel();
        $twcontrolPanel->setCourseId($courseId);
        $twcontrolPanel->setEmailId($username);
        $twcontrolPanel->setEnrollmentDate($dateObject);
        $twcontrolPanel->setNoClassessCompleted(0);
        $twcontrolPanel->setIscomplete(0);
        $twcontrolPanel->setPayIsComplete($payIsComplete);
        $twcontrolPanel->setPaypalOrderId($paypalOrderId);
        $twcontrolPanel->setPaypalPaymentId($paypalPaymentId);

        //save the information
        $this->entityManager->persist($twcontrolPanel);
        $this->entityManager->flush();
        $this->entityManager->clear();

        //guarda en las tablas los datos iniciales del seguimiento
        //del curso
        if ($isFree == TRUE) {
            $this->fillTwClassSection($courseId, $username);
        }


        return $response = array(
            "code" => 0,
            "message" => "El curso se asigno exitosamente"
        );
    }

    /**
     * Llena las tablas de trabajo tw_class y tw_section
     * para poder llevar el control del curso en el front end
     *
     * @param [Integer] $courseId
     * @param [String] $username
     * @return void
     */
    public function fillTwClassSection($courseId, $username)
    {

        $controlPanel = $this->getTwControlPanelBy($courseId, $username);
        $sections = $this->getCourseSections($courseId);


        foreach ($sections as $section) {
            $tw_section = new TwSection();

            $this->logger->debug('id: ' . $controlPanel->getId());
            $this->logger->debug('controlpid: ' . $section->getId());
            $this->logger->debug('classes completed: ' . 0);


            $tw_section->setControlPanelId($controlPanel->getId());
            $tw_section->setSectionId($section->getId());
            $tw_section->setClassescompleted(0);
            $tw_section->setSection($section);
            $this->entityManager->persist($tw_section);

            foreach ($section->getClasses() as $clase) {
                $tw_class = new TwClass();

                $this->logger->debug('$controlPanel -->getId: ' . $controlPanel->getId());
                $this->logger->debug('$section-> getId()' . $section->getId());
                $this->logger->debug('$clase->getClassId() ' . $clase->getClassId());


                $tw_class->setControlPanelId($controlPanel->getId());
                $tw_class->setSectionId($section->getId());
                $tw_class->setClassId($clase->getClassId());
                $tw_class->setClase($clase);
                $tw_class->setIscompleted(0);
                $tw_class->setTwSection($tw_section);

                $this->entityManager->persist($tw_class);
            }
            //$this->logger->debug("obj : ". $section->getDescription());        
        }

        $this->entityManager->flush();
        $this->entityManager->clear();


    }

     /**
      * Obtiene un item de tw class
      *
      * @return TwClass
      * */
    public function getTwClass($classId, $controlPanelId, $sectionId) {

        $repository = $this->entityManager->getRepository('AppBundle:TwClass');

        $tw_class = $repository->findOneBy(
            ['controlPanelId' => $controlPanelId,
                'sectionId' => $sectionId,
                'classId' => $classId]
        //['price' => 'ASC']
        );

        $tw_class = $this->getTrClass($tw_class);

        return $tw_class;
    }

    /**
     * Coloca como completado una clase
     *
     */
    public function saveTwClassComplete($classId, $controlPanelId, $sectionId) {

        $em = $this->entityManager;

        $repository = $em->getRepository('AppBundle:TwClass');

        $tw_class = $repository->findOneBy(
            ['controlPanelId' => $controlPanelId,
                'sectionId' => $sectionId,
                'classId' => $classId]

        );


        $tw_class -> setIscompleted(1);

        $em->flush();



    }

    /**
     * Obtiene las secciones de un curso por el ID
     *
     */
    public function getCourseSections($courseId)
    {

        $repository = $this->entityManager->getRepository('AppBundle:TrCourseSection');

        $sections = $repository->findBy(
            ['courseId' => $courseId]
        //['price' => 'ASC']
        );

        return $sections;
    }

    /**
     *
     * @param $courseId
     * @return \AppBundle\Entity\TrCourseSection[]|array
     */
    public function getTrCourseSectionsPremier ($courseId) {
        return $this->getCourseSections($courseId);

    }

    /**
     *
     * obtiene el temario de un curso determinado
     * @param $courseId courseId
     * @return TrCourseSection (array)
     * */
    public function getTrCourseSections($courseId) {

         $sections  = $this->getCourseSections($courseId);

        //TODO add tr classes

        foreach ($sections as $section) {

            $classes = $section->getClasses();

            foreach($classes as $class) {

                $class->setVideourl('');

            }

        }

        return $sections;

    }

    /**
     * @return TwSection[]
     **/
    public function getTwCourseSections($courseId, $username)
    {

        $tw_controlP = $this->getTwControlPanelBy($courseId, $username);

        $repository = $this->entityManager->getRepository('AppBundle:TwSection');

        $sections = $repository->findBy(
            ['controlPanelId' => $tw_controlP->getId()]
        //['price' => 'ASC']
        );

        foreach ($sections as $section) {

            $section->setTwClasses($this->getTwClasses($section));

        }

        return $sections;

    }

    /*
    * @return TwClass[]
    */
    public function getTwClasses(TwSection $twSection)
    {

        $repository2 = $this->entityManager->getRepository('AppBundle:TwClass');


        $twclasses = $repository2->findBy(
            ['controlPanelId' => $twSection->getControlPanelId(),
                'sectionId' => $twSection->getSectionId()]
        //['price' => 'ASC']
        );
        foreach ($twclasses as $twclass) {
            $twclass->setClase($this->getTrClass($twclass));
        }

        return $twclasses;


    }

    /**
     * @param $tw_class clase
     */
    public function getTrClass(TwClass $tw_class)
    {

        $repository = $this->entityManager->getRepository('AppBundle:TrClass');
        $clase = $repository->findOneBy([
            'sectionId' => $tw_class->getSectionId(),
            'classId' => $tw_class->getClassId()
        ]);

        $files = $this->getFilesByClase($tw_class);

        $clase->setFiles($files);


        $this->logger->debug(var_export($clase, true));;

        return $clase;
    }

    /**
     * Metodo para obtener los archivos relacionados a una clase determinada
     */
    public function getFilesByClase(TwClass $tw_class) {

        $repository = $this->entityManager->getRepository('AppBundle:TrClassFiles');

       $files = $repository->findBy([
            'sectionId' => $tw_class->getSectionId(),
            'classId' => $tw_class->getClassId()
        ]);


        return $files;
    }


    /**
     * Obtiene los cursos por user id
     */
    public function getCoursesByUser($username) {

        $repository = $this->entityManager->getRepository('AppBundle:TwControlPanel');

        //busca coursos en los que esta inscrito el usuario
        $controls = $repository->findBy([
            'emailId' => $username
        ]);

        $courses = new ArrayCollection();

        foreach ($controls as $twcontrol) {
          $courses->add($this->getById($twcontrol->getCourseId()));
        }

        return $courses;

    }

    public function getUsersByCourse($courseId) {
        $repository = $this->entityManager->getRepository('AppBundle:TwControlPanel');
          //busca coursos en los que esta inscrito el usuario
        $rs = $repository->findBy([
            'courseId' => $courseId
        ]);

        $users = new ArrayCollection();

        foreach ($rs as $user) {
           $userdb = $this->userService->getUserByMail($user->getEmailId());
            $userview = new UserView();
            $userview->setCompletename($userdb->getCompletename());
            $userview->setEmail($userdb->getEmail());
            $userview->setIdcountry($userdb->getIdcountry());
            $userview->setEnrollmentDate($user->getEnrollmentDate());
            $userview->setPayIsComplete($user->getPayIsComplete());
            $userview->setPaypalOrderId($user->getPaypalOrderId());
            $userview->setPaypalPaymentId($user->getPaypalPaymentId());
            $users->add($userview);

        }

      return $users;
    }

    public function getUsersByLikeMail($email) {
        //TODO quitar los campos sensibles
        $result = $this->entityManager->getRepository('AppBundle:TwUser')->createQueryBuilder('o')
            ->where('o.email LIKE :email')
            ->setParameter('email', $email. '%')
            ->getQuery()
            ->getResult();
        return $result;
    }

    /**
     *Add new course
     */
    public function addNewCourse(TcCourse $course)
    {

        $conn = $this->entityManager->getConnection();

        $dateObject = new \DateTime();


        $sql = '
        INSERT INTO  tc_course (courseName, author_id, courseDesc, isFree, isOnline, cost,imgThumb, shortdesc,imgcourse,creationDate)
        values(:courseName, :author_id, :courseDesc, :isFree, :isOnline, :cost, :imgThumb, :shortdesc, :imgcourse, :creationDate)
      ';

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['courseName' => $course->getCoursename(), 'author_id' => $course->getAuthorId(),
            'courseDesc' => $course->getCoursedesc(), 'isFree' => $course->getIsfree(), 'isOnline' => $course->getIsOnline(),
            'cost' => $course->getCost(), 'imgThumb' => $course->getImgthumb(),
            'shortdesc' => $course->getShortdesc(), 'imgcourse' => $course->getImgcourse(), "creationDate" => date_format($dateObject, 'Y-m-d')
        ]);

        return $result;

    }

    /**
     *
     * @param TcCourse $course
     * @return array
     */
    public function updateCourse(TcCourse $course) {
        $em = $this->entityManager;

        $repository = $em->getRepository('AppBundle:TcCourse');

        $coursedb =  $repository->find($course ->getId());

        $coursedb->setCoursename($course->getCoursename());
        $coursedb->setCoursedesc($course->getCoursedesc());
        $coursedb->setImgthumb($course->getImgthumb());
        $coursedb->setImgcourse($course->getImgcourse());
        $coursedb->setCost($course->getCost());
        $coursedb->setIsfree($course->getIsfree());
        $coursedb->setIsOnline($course->getIsOnline());
        $coursedb->setShortdesc($course->getShortdesc());
        $coursedb->setAuthorId($course->getAuthorId());
        $coursedb->setUrlCourseOnline($course->getUrlCourseOnline());

        $em->flush(); //guarda los cambios


        return $response = array(
            "code" => 0,
            "message" => "Se actualizo el curso de forma exitosa"
        );

    }

    /***
     *
     * Actualiza una clase
     *
     * @param TrClass $clase
     * @return response
     */
    public function updateClase(TrClass $clase) {

        $em = $this->entityManager;

        $repository = $em->getRepository('AppBundle:TrClass');

        $clasedb = $repository->findOneBy([
            'sectionId' => $clase->getSectionId(),
            'classId' => $clase->getClassId()
        ]);

        $clasedb->setClassdescription($clase->getClassdescription());
        $clasedb ->setVideourl($clase->getVideourl());

        $em->flush(); //guarda los cambios


        return $response = array(
            "code" => 0,
            "message" => "Se actualizo la clase de forma exitosa"
        );

    }

    /**
     *
     * actualiza un archivo
     * @param TrClassFiles $file
     * @return response
     *
     */
    public function updateFile(TrClassFiles $file) {

        $em = $this->entityManager;

        $repository = $em->getRepository('AppBundle:TrClassFiles');

        $filedb = $repository->findOneBy([
            'id' => $file->getId()
        ]);

        $filedb->setFilePath($file->getFilePath());
        $filedb->setFileName($file->getFileName());

        $em->flush(); //guarda los cambios

        return $response = array(
            "code" => 0,
            "message" => "Se actualizo el archivo de forma exitosa"
        );


    }

    /**
     * Actualiza una seccion
    */
    public function updateSection(TrCourseSection $section, $id) {
        $em = $this->entityManager;

        $repository = $em->getRepository('AppBundle:TrCourseSection');

        $sectiondb =  $repository->find($id);
        $sectiondb->setDescription($section->getDescription());

        $em->flush(); //guarda los cambios


        return $response = array(
            "code" => 0,
            "message" => "Se actualizo la unidad de forma exitosa"
        );

    }

    /**
     * Agrega un nuevo archivo a una clase
     */
    public function addFileToClass(TrClassFiles $file) {
        //save the information
        $this->entityManager->persist($file);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $response = array(
            "code" => 0,
            "message" => "Se agrego el archivo de manera exitosa"
        );

    }

    /**
     * Guarda una nueva seccion (Unidad de un curso)
     *
    */
    public function saveNewSection(TrCourseSection $section){

        $repository = $this->entityManager->getRepository('AppBundle:TrCourseSection');

        //busca todas las secciones del curso
        $sections = $repository->findBy([
            'courseId' => $section->getCourseId()
        ]);

        $numSections = count($sections);

        $sectionNumber = $numSections + 1;

        $this->logger->debug('Section number: ' . $sectionNumber );

        $section->setSectionnumber($sectionNumber);
        $section->setNumberclasses(0);

        //save the information
        $this->entityManager->persist($section);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $response = array(
            "code" => 0,
            "message" => "Se agrego la unidad de manera exitosa"
        );


    }

    /**
     * Agrega una nueva clase a la base
     */
    public function addNewTrClass(TrClass $clase) {

        $repository = $this->entityManager->getRepository('AppBundle:TrClass');

        //obtiene todas las clases de una seccion especifica
        $clases = $repository->findBy([
            'sectionId' => $clase->getSectionId()
        ]);

        $rep =  $this->entityManager->getRepository('AppBundle:TrCourseSection');

        $section =  $rep->find($clase ->getSectionId());


        $numclases = count($clases);

        $classId = $numclases + 1;

        $clase->setClassId($classId);
        $clase->setActivitytype(1);
        $clase->setSection($section);

        $this->logger->debug('class ID: ' . $classId );
        $this->logger->debug('section ID: ' . $clase->getSectionId() );


        //save the information
        $this->entityManager->persist($clase);
        $this->entityManager->flush();
        $this->entityManager->clear();

        return $response = array(
            "code" => 0,
            "message" => "Se agrego la clase de manera exitosa"
        );

    }
}