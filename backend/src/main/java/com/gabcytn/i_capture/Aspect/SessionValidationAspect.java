package com.gabcytn.i_capture.Aspect;

import jakarta.servlet.http.HttpServletRequest;
import org.aspectj.lang.ProceedingJoinPoint;
import org.aspectj.lang.annotation.Around;
import org.aspectj.lang.annotation.Aspect;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Component;

import java.util.Map;

@Aspect
@Component
public class SessionValidationAspect {
    private final Logger LOGGER = LoggerFactory.getLogger(SessionValidationAspect.class);
    private HttpServletRequest servletRequest;

    @Autowired
    public void setServletRequest(HttpServletRequest servletRequest) {
        this.servletRequest = servletRequest;
    }

    @Around("execution(* com.gabcytn.i_capture.Controller.AuthController.changePassword(..)) && args(request)")
    public Object beforeChangePassword(ProceedingJoinPoint joinPoint, Map<String, String> request) throws Throwable {
        return validateUUIDs(getStoredUuid(), request.get("id"), joinPoint);
    }

    @Around("execution(* com.gabcytn.i_capture.Controller.UserController.changeDisplayImage(..))")
    public Object beforeChangeDisplayImage (ProceedingJoinPoint joinPoint) throws Throwable {
        String id = joinPoint.getArgs()[0].toString();
        return validateUUIDs(getStoredUuid(), id, joinPoint);
    }

    @Around("execution(* com.gabcytn.i_capture.Controller.PostsController.createPost(..))")
    public Object beforeCreatePost (ProceedingJoinPoint joinPoint) throws Throwable {
        String id = joinPoint.getArgs()[0].toString();
        return validateUUIDs(getStoredUuid(), id, joinPoint);
    }

    private String getStoredUuid () {
        String sessionId = servletRequest.getSession().getId();
        return (String) servletRequest.getSession().getAttribute(sessionId);
    }

    private Object validateUUIDs (String storedUuid, String requestUuid, ProceedingJoinPoint joinPoint) throws Throwable {
        if (storedUuid.equals(requestUuid)) {
            LOGGER.info("UUIDs are valid");
            return joinPoint.proceed();
        }

        LOGGER.warn("UUIDs do not match!");
        return new ResponseEntity<Void>(HttpStatus.BAD_REQUEST);
    }
}
