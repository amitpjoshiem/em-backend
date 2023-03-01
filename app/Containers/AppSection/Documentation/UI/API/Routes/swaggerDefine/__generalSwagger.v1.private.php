<?php

declare(strict_types=1);

/**
 * @OA\Info(title="Swd", version="1.0.0", description="Swd API Swagger server")
 */

/**
 * @OA\Server(url="https://api-dev-app.swdgroup.net/api/v1", description="AWS Dev Server")
 * @OA\Server(url="https://api-stage-app.swdgroup.net/api/v1", description="AWS Stage Server")
 * @OA\Server(url="https://swd.local/api/v1", description="Local Server")
 * @OA\Server(url="http://localhost/api/v1", description="Docker Server")
 */

/**
 * @OA\ExternalDocumentation(url="/docs/postman-collection", description="Find out additional Postman Collection Documentation")
 */

/**
 * @OA\Tag(name="Init", description="Operations about Init")
 * @OA\Tag(name="HealthCheck", description="Health Check Ping")
 * @OA\Tag(name="OAuth2", description="Operations about OAuth2")
 * @OA\Tag(name="User", description="Operations about Users")
 * @OA\Tag(name="Process", description="Operations about Processes")
 * @OA\Tag(name="Factor", description="Operations about Factors")
 * @OA\Tag(name="Checklist", description="Operations about Checklists")
 * @OA\Tag(name="Question", description="Operations about Questions")
 * @OA\Tag(name="Investment", description="Operations about Investment")
 * @OA\Tag(name="DataSource", description="Operations about DataSource")
 * @OA\Tag(name="Screen", description="Operations about Screen")
 * @OA\Tag(name="Media", description="Upload Images")
 */

/**
 * @OA\OpenApi(
 *    security={{"bearerAuth": {}}}
 * )
 *
 * @OA\Components(
 *     @OA\SecurityScheme(
 *         securityScheme="bearerAuth",
 *         type="http",
 *         scheme="bearer",
 *         bearerFormat="JWT",
 *     )
 * )
 */

/**
 * @OA\Schema(
 *      schema="Error",
 *      required={"code", "message"},
 *      @OA\Property(
 *          property="code",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string"
 *      )
 *  )
 */

/**
 * @OA\Get(
 *     path="/ping",
 *     tags={"HealthCheck"},
 *     summary="Applications Services HealthCheck",
 *     operationId="PingCall",
 *     deprecated=false,
 *     @OA\Response(
 *         response=200,
 *         description="All Services work",
 *         @OA\JsonContent(
 *             @OA\Property (property="message", type="string", example="OK"),
 *         ),
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Some Services have a problems!",
 *         @OA\JsonContent(
 *             @OA\Property (property="message", type="string", example="FAILED"),
 *         ),
 *     ),
 * )
 */
