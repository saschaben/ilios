<?php

namespace Ilios\CoreBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;

/**
 * CourseLearningMaterial controller Test.
 * @package Ilios\CoreBundle\Test\Controller;
 */
class CourseLearningMaterialControllerTest extends AbstractControllerTest
{
    /**
     * @return array|string
     */
    protected function getFixtures()
    {
        return [
            'Ilios\CoreBundle\Tests\Fixture\LoadCourseLearningMaterialData'
        ];
    }

    /**
     * @return array|string
     */
    protected function getPrivateFields()
    {
        return [
        ];
    }

    public function testGetCourseLearningMaterial()
    {
        $courseLearningMaterial = $this->container
            ->get('ilioscore.dataloader.courselearningmaterial')
            ->getOne()
        ;

        $this->createJsonRequest(
            'GET',
            $this->getUrl(
                'get_courselearningmaterials',
                ['id' => $courseLearningMaterial['id']]
            )
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize($courseLearningMaterial),
            json_decode($response->getContent(), true)['courseLearningMaterials'][0]
        );
    }

    public function testGetAllCourseLearningMaterials()
    {
        $this->createJsonRequest('GET', $this->getUrl('cget_courselearningmaterials'));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize(
                $this->container
                    ->get('ilioscore.dataloader.courselearningmaterial')
                    ->getAll()
            ),
            json_decode($response->getContent(), true)['courseLearningMaterials']
        );
    }

    public function testPostCourseLearningMaterial()
    {
        $data = $this->container->get('ilioscore.dataloader.courselearningmaterial')
            ->create();
        $postData = $data;
        //unset any parameters which should not be POSTed
        unset($postData['id']);

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_courselearningmaterials'),
            json_encode(['courseLearningMaterial' => $postData])
        );

        $response = $this->client->getResponse();
        $headers  = [];

        $this->assertEquals(Codes::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $this->assertEquals(
            $data,
            json_decode($response->getContent(), true)['courseLearningMaterials'][0],
            $response->getContent()
        );
    }

    public function testPostBadCourseLearningMaterial()
    {
        $invalidCourseLearningMaterial = $this->container
            ->get('ilioscore.dataloader.courselearningmaterial')
            ->createInvalid()
        ;

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_courselearningmaterials'),
            json_encode(['courseLearningMaterial' => $invalidCourseLearningMaterial])
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutCourseLearningMaterial()
    {
        $data = $this->container
            ->get('ilioscore.dataloader.courselearningmaterial')
            ->getOne();

        $postData = $data;
        //unset any parameters which should not be POSTed
        unset($postData['id']);
        $this->createJsonRequest(
            'PUT',
            $this->getUrl(
                'put_courselearningmaterials',
                ['id' => $data['id']]
            ),
            json_encode(['courseLearningMaterial' => $postData])
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize($data),
            json_decode($response->getContent(), true)['courseLearningMaterial']
        );
    }

    public function testDeleteCourseLearningMaterial()
    {
        $courseLearningMaterial = $this->container
            ->get('ilioscore.dataloader.courselearningmaterial')
            ->getOne()
        ;

        $this->client->request(
            'DELETE',
            $this->getUrl(
                'delete_courselearningmaterials',
                ['id' => $courseLearningMaterial['id']]
            )
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->client->request(
            'GET',
            $this->getUrl(
                'get_courselearningmaterials',
                ['id' => $courseLearningMaterial['id']]
            )
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testCourseLearningMaterialNotFound()
    {
        $this->createJsonRequest(
            'GET',
            $this->getUrl('get_courselearningmaterials', ['id' => '0'])
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND);
    }
}
