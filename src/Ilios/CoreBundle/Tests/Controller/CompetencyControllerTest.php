<?php

namespace Ilios\CoreBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;

/**
 * Competency controller Test.
 * @package Ilios\CoreBundle\Test\Controller;
 */
class CompetencyControllerTest extends AbstractControllerTest
{
    /**
     * @return array|string
     */
    protected function getFixtures()
    {
        return [
            'Ilios\CoreBundle\Tests\Fixture\LoadCompetencyData',
            'Ilios\CoreBundle\Tests\Fixture\LoadSchoolData',
            'Ilios\CoreBundle\Tests\Fixture\LoadObjectiveData',
            'Ilios\CoreBundle\Tests\Fixture\LoadCompetencyData',
            'Ilios\CoreBundle\Tests\Fixture\LoadCompetencyData',
            'Ilios\CoreBundle\Tests\Fixture\LoadAamcPcrsData',
            'Ilios\CoreBundle\Tests\Fixture\LoadProgramYearData'
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

    public function testGetCompetency()
    {
        $competency = $this->container
            ->get('ilioscore.dataloader.competency')
            ->getOne()
        ;

        $this->createJsonRequest(
            'GET',
            $this->getUrl(
                'get_competencies',
                ['id' => $competency['id']]
            )
        );

        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize($competency),
            json_decode($response->getContent(), true)['competencies'][0]
        );
    }

    public function testGetAllCompetencies()
    {
        $this->createJsonRequest('GET', $this->getUrl('cget_competencies'));
        $response = $this->client->getResponse();

        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize(
                $this->container
                    ->get('ilioscore.dataloader.competency')
                    ->getAll()
            ),
            json_decode($response->getContent(), true)['competencies']
        );
    }

    public function testPostCompetency()
    {
        $data = $this->container->get('ilioscore.dataloader.competency')
            ->create();
        $postData = $data;
        //unset any parameters which should not be POSTed
        unset($postData['id']);
        unset($postData['children']);

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_competencies'),
            json_encode(['competency' => $postData])
        );

        $response = $this->client->getResponse();
        $headers  = [];

        $this->assertEquals(Codes::HTTP_CREATED, $response->getStatusCode(), $response->getContent());
        $this->assertEquals(
            $data,
            json_decode($response->getContent(), true)['competencies'][0],
            $response->getContent()
        );
    }

    public function testPostBadCompetency()
    {
        $invalidCompetency = $this->container
            ->get('ilioscore.dataloader.competency')
            ->createInvalid()
        ;

        $this->createJsonRequest(
            'POST',
            $this->getUrl('post_competencies'),
            json_encode(['competency' => $invalidCompetency])
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testPutCompetency()
    {
        $data = $this->container
            ->get('ilioscore.dataloader.competency')
            ->getOne();

        $postData = $data;
        //unset any parameters which should not be POSTed
        unset($postData['id']);
        unset($postData['children']);

        $this->createJsonRequest(
            'PUT',
            $this->getUrl(
                'put_competencies',
                ['id' => $data['id']]
            ),
            json_encode(['competency' => $postData])
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_OK);
        $this->assertEquals(
            $this->mockSerialize($data),
            json_decode($response->getContent(), true)['competency']
        );
    }

    public function testDeleteCompetency()
    {
        $competency = $this->container
            ->get('ilioscore.dataloader.competency')
            ->getOne()
        ;

        $this->client->request(
            'DELETE',
            $this->getUrl(
                'delete_competencies',
                ['id' => $competency['id']]
            )
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NO_CONTENT, $response->getStatusCode());
        $this->client->request(
            'GET',
            $this->getUrl(
                'get_competencies',
                ['id' => $competency['id']]
            )
        );

        $response = $this->client->getResponse();
        $this->assertEquals(Codes::HTTP_NOT_FOUND, $response->getStatusCode());
    }

    public function testCompetencyNotFound()
    {
        $this->createJsonRequest(
            'GET',
            $this->getUrl('get_competencies', ['id' => '0'])
        );

        $response = $this->client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_NOT_FOUND);
    }
}
